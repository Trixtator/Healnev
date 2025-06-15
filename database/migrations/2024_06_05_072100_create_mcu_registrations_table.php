<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcuRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('mcu_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->date('birthdate');
            $table->string('passport');
            $table->string('address');
            $table->date('reservation_date');
            $table->string('time');
            $table->string('package');
            $table->string('destination');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcu_registrations');
    }
}
