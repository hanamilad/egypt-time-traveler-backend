<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_id');
            $table->string('url', 500);
            $table->string('alt_en', 255);
            $table->string('alt_de', 255);
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->index(['tour_id', 'is_primary'], 'idx_tour_primary');
            $table->index(['tour_id', 'sort_order'], 'tour_images_sort_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_images');
    }
};

