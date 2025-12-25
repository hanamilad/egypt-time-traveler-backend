<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tour_pricings');
        Schema::create('tour_pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->integer('people_count');
            $table->decimal('price', 10, 2); // Total price for this number of people
            $table->timestamps();

            // Ensure unique combination of tour and people count
            $table->unique(['tour_id', 'people_count']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_pricings');
    }
};
