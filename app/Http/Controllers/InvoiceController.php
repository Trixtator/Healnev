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
            $uniqueOrderId = $order->order_code . '-' . time();

            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($midtransParams);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
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
     * Terima notifikasi webhook dari Midtrans
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $fullOrderId = $notification->order_id;
            $orderId = explode('-', $fullOrderId)[0]; // Ambil bagian order_code saja

            $transaction = $notification->transaction_status;

            $order = Order::where('order_code', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            if (in_array($transaction, ['capture', 'settlement'])) {
                $order->payment_status = 'paid';
                $order->save();

                Mail::to($order->user->email)->send(new InvoicePaid($order));
            } elseif (in_array($transaction, ['cancel', 'deny', 'expire'])) {
                $order->payment_status = 'failed';
                $order->save();
            }

            return response()->json(['message' => 'Notifikasi diproses']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
