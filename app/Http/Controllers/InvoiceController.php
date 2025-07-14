<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePaid;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Tampilkan halaman invoice.
     */
    public function show(Order $order)
    {
        $order = Order::where('id', $order->id)->first();
        
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Akses ditolak.');
        }

        return view('invoice', compact('order'));
    }

    /**
     * Handle pembayaran dan kirim Snap Token (POST)
     */
    public function pay(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        try {
            // Gunakan format yang lebih konsisten
            $uniqueOrderId = $order->order_code . '-' . $order->id . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
<<<<<<< HEAD
                    'first_name' => $request->user()->name,
                    'email' => $request->user()->email,
                ]
=======
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'custom_field1' => $order->id, // Tambahkan order ID untuk memudahkan tracking
>>>>>>> af162f85b0ead4ae875514615846c3a05799e27c
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
<<<<<<< HEAD
            return response()->json(['error' => 'Gagal memproses pembayaran: ' . $e->getMessage()], 500);
=======
            Log::error('Midtrans payment error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat sesi pembayaran: ' . $e->getMessage()], 500);
>>>>>>> af162f85b0ead4ae875514615846c3a05799e27c
        }
    }

    /**
     * Unduh invoice PDF
     */
    public function download(Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        $pdf = Pdf::loadView('invoices.pdf', compact('order'));
        return $pdf->download('invoice-' . $order->order_code . '.pdf');
    }

    /**
<<<<<<< HEAD
     * Handle Webhook dari Midtrans
=======
     * Check payment status (untuk AJAX polling)
>>>>>>> af162f85b0ead4ae875514615846c3a05799e27c
     */
    public function checkStatus($id)
    {
<<<<<<< HEAD
        try {
            $notification = new Notification();

            $fullOrderId = $notification->order_id;
            $orderCode = explode('-', $fullOrderId)[0];

            $order = Order::where('order_code', $orderCode)->first();

            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            $transaction = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $settlementTime = $notification->settlement_time ?? now();

            if (in_array($transaction, ['capture', 'settlement'])) {
                $order->payment_status = 'paid';
                $order->payment_method = $paymentType;
                $order->paid_at = $settlementTime;
                $order->save();

                Mail::to($order->user->email)->send(new InvoicePaid($order));
            } elseif (in_array($transaction, ['cancel', 'deny', 'expire'])) {
                $order->payment_status = 'failed';
                $order->save();
            }

            return response()->json(['message' => 'Notifikasi berhasil diproses']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
=======
        $order = Order::findOrFail($id);
        
        if (auth()->id() !== $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
>>>>>>> af162f85b0ead4ae875514615846c3a05799e27c
        }

        return response()->json([
            'payment_status' => $order->payment_status,
            'paid_at' => $order->paid_at,
            'payment_method' => $order->payment_method
        ]);
    }
}
