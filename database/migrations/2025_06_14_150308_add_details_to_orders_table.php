<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kolom untuk menyimpan ID rumah sakit
            $table->foreignId('hospital_id')->nullable()->after('paket_id')->constrained('rumah_sakits');

            // Tambahkan kolom untuk menyimpan jam booking
            $table->time('booking_time')->nullable()->after('booking_date');

            // Tambahkan kolom untuk menyimpan metode pembayaran
            $table->string('payment_method')->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
