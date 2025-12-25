<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_availability', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_id');
            $table->date('date');
            $table->string('status')->default('available');
            $table->integer('available_seats')->default(0);
            $table->decimal('special_price', 10, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->unique(['tour_id', 'date'], 'unique_tour_date');
            $table->index('date', 'idx_date');
            $table->index('is_available', 'idx_available');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_availability');
    }
};

