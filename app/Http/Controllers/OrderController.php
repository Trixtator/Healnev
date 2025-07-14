<?php

// File: app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User; // Asumsi Anda punya model User
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Mail; // <-- Tambahkan di atas
use App\Mail\OrderPaid;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InvoicePaidMail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        // Setup konfigurasi Midtrans dari file .env
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Fungsi untuk mengecek kuota yang tersedia pada tanggal tertentu.
     * Dipanggil oleh JavaScript saat pengguna memilih tanggal.
     */
    public function checkQuota(Request $request, Paket $paket)
    {
        // Validasi input: pastikan tanggal ada dan formatnya benar
        $request->validate(['tanggal' => 'required|date']);

        $tanggal = $request->input('tanggal');
        $kuota_harian = 5; // Batas kuota harian

        // Hitung jumlah order untuk paket dan tanggal yang sama,
        // yang statusnya bukan 'failed' atau 'expired'.
        $bookingCount = Order::where('paket_id', $paket->id)
                            ->whereDate('booking_date', $tanggal)
                            ->whereNotIn('payment_status', ['failed', 'expired'])
                            ->count();

        $sisa_kuota = $kuota_harian - $bookingCount;

        // Jika kuota masih ada
        if ($sisa_kuota > 0) {
            return response()->json([
                'available' => true,
                'sisa_kuota' => $sisa_kuota,
            ]);
        }

        // Jika kuota habis
        return response()->json(['available' => false]);
    }

    /**
     * FIXED: Fungsi untuk membuat order baru dengan perlindungan double click yang kuat
     * Dipanggil oleh JavaScript saat pengguna menekan tombol "Lanjut ke Pembayaran".
     */
    public function createOrder(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'paket_id' => 'required|exists:pakets,id',
                'tanggal_booking' => 'required|date|after:today',
                'booking_time' => 'required|string',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk membuat pesanan.'
                ], 401);
            }

            $paketId = $validated['paket_id'];
            $tanggalBooking = $validated['tanggal_booking'];
            $bookingTime = $validated['booking_time'];

            // ✅ CRITICAL: Cek duplicate order dalam 5 menit terakhir
            $recentOrder = Order::where('user_id', $user->id)
                ->where('paket_id', $paketId)
                ->where('booking_date', $tanggalBooking)
                ->where('booking_time', $bookingTime)
                ->where('created_at', '>=', now()->subMinutes(5))
                ->whereIn('payment_status', ['pending', 'unpaid', 'paid'])
                ->first();

            if ($recentOrder) {
                Log::warning('Duplicate order attempt detected', [
                    'user_id' => $user->id,
                    'paket_id' => $paketId,
                    'existing_order_id' => $recentOrder->id,
                    'booking_date' => $tanggalBooking,
                    'booking_time' => $bookingTime
                ]);

                // Jika order sudah ada dan statusnya pending/unpaid, redirect ke invoice
                if (in_array($recentOrder->payment_status, ['pending', 'unpaid'])) {
                    return response()->json([
                        'success' => true,
                        'message' => 'You already have a pending order for this package.',
                        'redirect_url' => route('invoice.show', $recentOrder->id)
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'You already have a recent booking for this package and time. Please wait a few minutes before booking again.'
                ], 409);
            }

            // ✅ Database transaction dengan row locking untuk prevent race condition
            $order = DB::transaction(function () use ($validated, $user) {
                $paket = Paket::findOrFail($validated['paket_id']);
                $paket->load('rumahsakit');

                $kuota_harian = 5;
                
                // ✅ Double-check quota dengan row locking
                $bookingCount = Order::where('paket_id', $validated['paket_id'])
                    ->whereDate('booking_date', $validated['tanggal_booking'])
                    ->whereNotIn('payment_status', ['failed', 'expired'])
                    ->lockForUpdate() // Lock rows untuk prevent race condition
                    ->count();

                if ($bookingCount >= $kuota_harian) {
                    throw new \Exception('Maaf, kuota pada tanggal tersebut baru saja habis.');
                }

                // ✅ Final check: Pastikan tidak ada order duplikat dengan kombinasi yang sama
                $existingOrder = Order::where('user_id', $user->id)
                    ->where('paket_id', $validated['paket_id'])
                    ->whereDate('booking_date', $validated['tanggal_booking'])
                    ->where('booking_time', $validated['booking_time'])
                    ->whereIn('payment_status', ['pending', 'unpaid', 'paid'])
                    ->lockForUpdate()
                    ->first();

                if ($existingOrder) {
                    // Jika sudah ada order yang pending/unpaid, return order yang sudah ada
                    if (in_array($existingOrder->payment_status, ['pending', 'unpaid'])) {
                        return $existingOrder;
                    }
                    
                    throw new \Exception('You already have a booking for this package on the selected date and time.');
                }

                // ✅ Create new order
                $order = Order::create([
                    'user_id' => $user->id,
                    'paket_id' => $paket->id,
                    'hospital_id' => $paket->rumahsakit->id,
                    'order_code' => 'ORDER-' . $paket->id . '-' . time() . '-' . strtoupper(Str::random(4)),
                    'booking_date' => $validated['tanggal_booking'],
                    'booking_time' => $validated['booking_time'],
                    'total_price' => $paket->harga,
                    'payment_status' => 'pending',
                ]);

                // Log successful order creation
                Log::info('New order created successfully', [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'paket_id' => $paket->id,
                    'booking_date' => $validated['tanggal_booking'],
                    'booking_time' => $validated['booking_time']
                ]);

                return $order;
            });

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'redirect_url' => route('invoice.show', $order->id)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Order creation validation failed', [
                'user_id' => auth()->id(),
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Order creation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'input' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function showInvoice(Order $order)
    {
        // Pastikan order ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Muat relasi paket agar bisa ditampilkan di view
        $order->load('paket', 'paket.rumahsakit');

        return view('invoice', compact('order')); // Kita akan buat file view 'invoice.blade.php'
    }

    public function processDummyPayment(Request $request, Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Pesanan ini sudah dibayar.'], 400);
        }

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                $order->payment_method = $request->payment_method;
                $order->payment_status = 'paid';
                $order->paid_at = now();
                $order->save();

                // Send email notification
                Mail::to($order->user->email)->send(new InvoicePaidMail($order));
            });

            Log::info('Payment processed successfully', [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'payment_method' => $request->payment_method
            ]);

            return response()->json(['message' => 'Pembayaran berhasil!']);

        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'error' => $e->getMessage()
            ]);

            return response()->json(['message' => 'Terjadi kesalahan saat memproses pembayaran.'], 500);
        }
    }

    /**
     * ✅ BONUS: Method untuk membatalkan order duplikat (jika diperlukan)
     */
    public function cancelOrder(Request $request, Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Cannot cancel paid order'], 400);
        }

        try {
            DB::transaction(function () use ($order) {
                $order->payment_status = 'cancelled';
                $order->cancelled_at = now();
                $order->save();
            });

            Log::info('Order cancelled successfully', [
                'order_id' => $order->id,
                'user_id' => $order->user_id
            ]);

            return response()->json(['message' => 'Order cancelled successfully']);

        } catch (\Exception $e) {
            Log::error('Order cancellation failed', [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'error' => $e->getMessage()
            ]);

            return response()->json(['message' => 'Failed to cancel order'], 500);
        }
    }

    /**
     * ✅ BONUS: Method untuk mendapatkan riwayat order user
     */
    public function getUserOrders(Request $request)
    {
        $user = auth()->user();
        
        $orders = Order::where('user_id', $user->id)
            ->with(['paket', 'paket.rumahsakit'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }
}