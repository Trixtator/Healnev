<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessful;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function bayar($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.']);
        }

        $orderId = $order->order_code . '-' . time(); // <- ini yang dikirim ke Midtrans

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name ?? 'Customer',
                'email' => $order->user->email ?? 'email@example.com',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   public function handleNotification(Request $request)
{
    // Konfigurasi Midtrans
    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
    \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    // Ambil raw input
    $rawBody = file_get_contents('php://input');
    if (empty($rawBody)) {
        \Log::error('⚠️ Midtrans notification: Empty payload');
        return response()->json(['message' => 'Empty payload'], 400);
    }

    // Decode payload
    $payload = json_decode($rawBody);
    if (!$payload || !isset($payload->transaction_status)) {
        \Log::error('⚠️ Midtrans notification: Invalid JSON or missing data', ['body' => $rawBody]);
        return response()->json(['message' => 'Invalid data'], 400);
    }

    // Cek ID
    $orderId = explode('-', $payload->order_id)[0];
    $order = Order::where('order_code', $orderId)->first();
    if (!$order) {
        \Log::error("❌ Order not found for ID: " . $orderId);
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Update status
    if (in_array($payload->transaction_status, ['capture', 'settlement'])) {
        $order->payment_status = 'paid';
        $order->save();
        \Mail::to($order->user->email)->send(new \App\Mail\InvoicePaid($order));
    } elseif (in_array($payload->transaction_status, ['expire', 'cancel'])) {
        $order->payment_status = 'failed';
        $order->save();
    }

    return response()->json(['message' => 'Notification processed']);
}



    public function paymentSuccess(Request $request)
    {
        $order_id = $request->get('order_id');
        $status = $request->get('status', 'success');
        $order = null;

        if ($order_id) {
            $order_code = explode('-', $order_id)[0];
            $order = Order::where('order_code', $order_code)
                ->orWhere('midtrans_order_id', $order_id)
                ->first();

            if ($order && $status == 'success' && $order->payment_status != 'paid') {
                $order->payment_status = 'paid';
                $order->save();

                try {
                    Mail::to($order->user->email)->send(new PaymentSuccessful($order));
                } catch (\Exception $e) {
                    Log::error('❌ Gagal kirim email: ' . $e->getMessage());
                }
            }
        }

        return view('payment.success', compact('order', 'status'));
    }
}
