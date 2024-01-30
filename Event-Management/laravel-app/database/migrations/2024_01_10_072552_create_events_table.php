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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('organizer_id');
            $table->string('name');
            $table->text('description');
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->string('address');
            $table->string('ticketPrice');
            $table->string('discount')->default('0%');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};