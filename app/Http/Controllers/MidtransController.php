<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use App\Models\Order;
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
            return redirect()->route('payment.success')->with('message', 'Pesanan sudah dibayar.');
        }

        try {
            $uniqueOrderId = $order->order_code . '-' . time();
            
            // Hapus callbacks, hanya gunakan JavaScript handlers
            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                ],
                'item_details' => [
                    [
                        'id' => $order->paket->id,
                        'price' => $order->total_price,
                        'quantity' => 1,
                        'name' => $order->paket->nama_paket,
                    ]
                ]
                // Callbacks dihapus - hanya mengandalkan JavaScript handlers
            ];

            $snapToken = Snap::getSnapToken($midtransParams);
            
            // Simpan token dan order_id untuk referensi
            $order->snap_token = $snapToken;
            $order->midtrans_order_id = $uniqueOrderId;
            $order->save();

            return view('payment.bayar', [
                'snapToken' => $snapToken, 
                'order' => $order
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat sesi pembayaran: ' . $e->getMessage());
        }
    }

    public function notificationHandler(Request $request)
    {
        try {
            $notification = new Notification();

            $order_id = $notification->order_id;
            $transaction_status = $notification->transaction_status;
            $fraud_status = $notification->fraud_status ?? 'accept';

            Log::info('Midtrans Notification', [
                'order_id' => $order_id,
                'transaction_status' => $transaction_status,
                'fraud_status' => $fraud_status
            ]);

            $order_code = explode('-', $order_id)[0];
            $order = Order::where('order_code', $order_code)->first();

            if (!$order) {
                Log::error('Order not found', ['order_code' => $order_code]);
                return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
            }

            if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
                if ($fraud_status == 'accept') {
                    $order->payment_status = 'paid';
                    $order->save();

                    try {
                        Mail::to($order->user->email)->send(new PaymentSuccessful($order));
                    } catch (\Exception $e) {
                        Log::error('Failed to send email', ['error' => $e->getMessage()]);
                    }

                    Log::info('Payment successful', ['order_id' => $order->id]);
                }
            } else if ($transaction_status == 'pending') {
                $order->payment_status = 'pending';
                $order->save();
            } else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
                $order->payment_status = 'failed';
                $order->save();
            }

            return response()->json(['message' => 'Notifikasi berhasil diproses.']);

        } catch (\Exception $e) {
            Log::error('Midtrans notification error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error processing notification'], 500);
        }
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
            
            // Update status jika belum diupdate oleh notification handler
            if ($order && $status == 'success' && $order->payment_status != 'paid') {
                $order->payment_status = 'paid';
                $order->save();
                
                try {
                    Mail::to($order->user->email)->send(new PaymentSuccessful($order));
                } catch (\Exception $e) {
                    Log::error('Failed to send email', ['error' => $e->getMessage()]);
                }
            }
        }
        
        return view('payment.success', compact('order', 'status'));
    }
}
