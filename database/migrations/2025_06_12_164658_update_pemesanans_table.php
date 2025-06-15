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
    Schema::table('pemesanans', function (Blueprint $table) {
        if (!Schema::hasColumn('pemesanans', 'user_id')) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        }

        if (!Schema::hasColumn('pemesanans', 'paket_id')) {
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('cascade');
        }

        if (!Schema::hasColumn('pemesanans', 'tanggal')) {
            $table->date('tanggal');
        }

        if (!Schema::hasColumn('pemesanans', 'status')) {
            $table->enum('status', ['pending', 'paid', 'expired', 'canceled'])->default('pending');
        }

        if (!Schema::hasColumn('pemesanans', 'midtrans_order_id')) {
            $table->string('midtrans_order_id')->nullable();
        }

        if (!Schema::hasColumn('pemesanans', 'expired_at')) {
            $table->timestamp('expired_at')->nullable();
        }
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
