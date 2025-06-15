<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;

class InvoiceController extends Controller
{
    /**
     * Menampilkan halaman invoice (HTML view).
     */
    public function __construct()
    {
        // Atur Server Key Anda
        Config::$serverKey = config('services.midtrans.server_key');
        // Atur ke mode Sandbox. Ganti menjadi true untuk mode Produksi.
        Config::$isProduction = config('services.midtrans.is_production');
        // Aktifkan sanitasi (default)
        Config::$isSanitized = true;
        // Aktifkan 3D Secure untuk kartu kredit
        Config::$is3ds = true;
    }

    // Ini adalah method yang akan dipanggil oleh tombol "Bayar Sekarang"
    public function show(Order $order)
    {
        // Validasi agar pengguna hanya bisa melihat invoice miliknya sendiri
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        return view('invoice', ['order' => $order]);
    }

    /**
     * Method untuk memproses pembayaran dan mendapatkan Snap Token.
     */
    public function pay($id)
{
    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
\Midtrans\Config::$isProduction = config('services.midtrans.is_production');
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;


    $order = Order::findOrFail($id);

    // Validasi jika sudah dibayar
    if ($order->payment_status === 'paid') {
        return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
    }

    // Buat Snap Token
    try {
        $uniqueOrderId = $order->order_code . '-' . time();
        $midtransParams = [
            'transaction_details' => [
                'order_id' => $uniqueOrderId, // Kirim ID yang sudah unik
        'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]
        ];

        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // Atur sesuai environment Anda

        $snapToken = \Midtrans\Snap::getSnapToken($midtransParams);

        return response()->json(['snap_token' => $snapToken]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Gagal membuat sesi pembayaran: ' . $e->getMessage()], 500);
    }
}


    /**
     * Mengunduh invoice dalam bentuk PDF.
     */
    public function download(Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Akses ditolak');
        }

        $pdf = Pdf::loadView('invoices.pdf', compact('order'));

        return $pdf->download('invoice-' . $order->order_code . '.pdf');
    }
}
