<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Order;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // Atur Server Key Anda
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        // Buat instance dari kelas notifikasi Midtrans
        $notification = new Notification();

        // Ambil order_id dan transaction_status dari notifikasi
        $order_id = $notification->order_id;
        $transaction_status = $notification->transaction_status;
        $fraud_status = $notification->fraud_status;

        // Cari pesanan di database Anda
        $order = Order::where('order_code', $order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // Handle status transaksi
        if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
            // Untuk kartu kredit, 'capture' berarti pembayaran berhasil
            // Untuk metode lain, 'settlement' berarti pembayaran berhasil
            if ($fraud_status == 'accept') {
                // Perbarui status pesanan Anda menjadi 'paid'
                $order->payment_status = 'paid';
                $order->save();
            }
        } else if ($transaction_status == 'pending') {
            // TODO: set status pembayaran di database Anda menjadi 'pending'
            $order->payment_status = 'pending';
            $order->save();
        } else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
            // TODO: set status pembayaran di database Anda menjadi 'failed'
            $order->payment_status = 'failed';
            $order->save();
        }

        // Beri respons ke Midtrans bahwa notifikasi sudah diterima
        return response()->json(['message' => 'Notifikasi berhasil diproses.']);
    }
}