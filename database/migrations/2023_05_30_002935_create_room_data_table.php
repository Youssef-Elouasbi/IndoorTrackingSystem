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
        Schema::create('room_data', function (Blueprint $table) {
            $table->id();
            $table->integer('room');
            $table->unsignedBigInteger('data_entries_id');
            $table->foreign('data_entries_id')->references('id')->on('data_entries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_data');
    }
};
