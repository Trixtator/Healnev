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
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Terhubung ke tabel users
        $table->tinyInteger('rating'); // Rating 1-5
        $table->text('message');
        $table->boolean('is_active')->default(false); // Default false (0)
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
