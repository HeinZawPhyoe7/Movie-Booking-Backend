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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->json('selected_seat_number');
            $table->integer('total_seat');
            $table->enum('seat_type', ['Deluxe', 'Premium', 'Sofa']);
            $table->string('fee');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('movie_detail_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('movie_detail_id')->references('id')->on('movie_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
