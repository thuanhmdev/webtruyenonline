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
        Schema::create('comic_genres', function (Blueprint $table) {
            // $table->id();

            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('comic_id');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('comic_id')->references('id')->on('comics')->onDelete('cascade');
            $table->primary(['genre_id', 'comic_id']);
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
