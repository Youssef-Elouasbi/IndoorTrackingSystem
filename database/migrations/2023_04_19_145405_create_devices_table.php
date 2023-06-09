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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('MAC')->unique();
            $table->string('Name');
            $table->enum('Status', ['LEARNING', 'USED'])->default('USED');
            $table->integer('Position_x')->nullable();
            $table->integer('Position_y')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            // $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
