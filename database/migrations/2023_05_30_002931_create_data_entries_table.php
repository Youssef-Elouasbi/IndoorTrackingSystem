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
        Schema::create('data_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('sensor_id');
            $table->integer('PWR');
            $table->dateTime('log_at');
            $table->timestamps();
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_entries');
    }
};
