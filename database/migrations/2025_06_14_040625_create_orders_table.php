<?php

// File: database/migrations/xxxx_xx_xx_xxxxxx_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap order
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID pengguna yang memesan
            $table->foreignId('paket_id')->constrained()->onDelete('cascade'); // ID paket yang dipesan
            
            $table->string('order_code')->unique(); // Kode unik untuk Midtrans & referensi kita
            $table->date('booking_date'); // Tanggal booking yang dipilih
            $table->decimal('total_price', 15, 2); // Harga total pesanan
            
            $table->string('payment_status')->default('pending'); // Status: pending, paid, failed, expired
            $table->string('snap_token')->nullable(); // Untuk menyimpan token dari Midtrans
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
