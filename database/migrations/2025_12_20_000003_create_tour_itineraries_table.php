<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_id');
            $table->string('time', 10);
            $table->string('title_en', 255);
            $table->string('title_de', 255);
            $table->text('description_en');
            $table->text('description_de');
            $table->integer('day_number');
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->index(['tour_id', 'day_number'], 'tour_itineraries_day_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_itineraries');
    }
};

