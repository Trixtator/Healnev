<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
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
     * Menampilkan halaman invoice HTML
     */
    public function show(Order $order)
    {
        $order = Order::where('id', $order->id)->first();
        
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        return view('invoice', ['order' => $order]);
    }

    /**
     * Proses pembayaran dan kirim Snap Token
     */
    public function pay($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        try {
            // Gunakan format yang lebih konsisten
            $uniqueOrderId = $order->order_code . '-' . $order->id . '-' . time();

            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'custom_field1' => $order->id, // Tambahkan order ID untuk memudahkan tracking
            ];

            $snapToken = Snap::getSnapToken($midtransParams);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans payment error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat sesi pembayaran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Unduh invoice dalam format PDF
     */
    public function download(Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Akses ditolak');
        }

        $pdf = Pdf::loadView('invoices.pdf', compact('order'));
        return $pdf->download('invoice-' . $order->order_code . '.pdf');
    }

    /**
     * Check payment status (untuk AJAX polling)
     */
    public function checkStatus($id)
    {
        $order = Order::findOrFail($id);
        
        if (auth()->id() !== $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'payment_status' => $order->payment_status,
            'paid_at' => $order->paid_at,
            'payment_method' => $order->payment_method
        ]);
    }
}
