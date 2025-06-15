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
     * Fungsi untuk membuat order baru dan mendapatkan Snap Token dari Midtrans.
     * Dipanggil oleh JavaScript saat pengguna menekan tombol "Lanjut ke Pembayaran".
     */
    public function createOrder(Request $request)
{
    $request->validate([
        'paket_id' => 'required|exists:pakets,id',
        'tanggal_booking' => 'required|date|after:today',
        'booking_time' => 'required',
    ]);

    try {
        $order = DB::transaction(function () use ($request) {
            $paket = Paket::find($request->paket_id);
            $paket->load('rumahsakit');

            $user = Auth::user();

            if (!$user) {
                throw new \Exception('Anda harus login untuk membuat pesanan.');
            }

            // Validasi kuota
            $kuota_harian = 5;
            $bookingCount = Order::where('paket_id', $request->paket_id)
                ->whereDate('booking_date', $request->tanggal_booking)
                ->where('payment_status', '!=', 'failed')
                ->lockForUpdate()->count();

            if ($bookingCount >= $kuota_harian) {
                throw new \Exception('Maaf, kuota pada tanggal tersebut baru saja habis.');
            }

            // CEK APAKAH ORDER SUDAH ADA
            $existingOrder = Order::where('user_id', $user->id)
                ->where('paket_id', $paket->id)
                ->whereDate('booking_date', $request->tanggal_booking)
                ->where('booking_time', $request->booking_time)
                ->whereIn('payment_status', ['pending', 'unpaid'])
                ->first();

            if ($existingOrder) {
                return $existingOrder;
            }

            // Jika belum ada, buat baru
            return Order::create([
                'user_id' => $user->id,
                'paket_id' => $paket->id,
                'hospital_id' => $paket->rumahsakit->id,
                'order_code' => 'ORDER-' . $paket->id . '-' . time() . '-' . strtoupper(Str::random(4)),
                'booking_date' => $request->tanggal_booking,
                'booking_time' => $request->booking_time,
                'total_price' => $paket->harga,
                'payment_status' => 'pending',
            ]);
        });

        return response()->json([
            'success' => true,
            'redirect_url' => route('invoice.show', $order->id)
        ]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
    }
}


    public function showInvoice(Order $order)
{
    // Pastikan order ini milik user yang sedang login
    if ($order->user_id !== Auth::id()) {
        abort(403, 'AKSES DITOLAK');
    }

    // Muat relasi paket agar bisa ditampilkan di view
    $order->load('paket');

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

    $order->payment_method = $request->payment_method;
    $order->payment_status = 'paid';
    $order->save();

    Mail::to($order->user->email)->send(new InvoicePaidMail($order));

    return response()->json(['message' => 'Pembayaran berhasil!']);
}

}