<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_id')->unique();
            $table->text('full_desc_en');
            $table->text('full_desc_de');
            $table->json('highlights_en');
            $table->json('highlights_de');
            $table->json('included_en');
            $table->json('included_de');
            $table->json('not_included_en');
            $table->json('not_included_de');
            $table->string('meeting_point', 500)->nullable();
            $table->decimal('map_lat', 10, 7)->nullable();
            $table->decimal('map_lng', 10, 7)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_details');
    }
};

