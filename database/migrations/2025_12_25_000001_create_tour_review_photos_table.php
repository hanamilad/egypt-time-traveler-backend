<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_review_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('review_id');
            $table->string('path', 500);
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('tour_reviews')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_review_photos');
    }
};
