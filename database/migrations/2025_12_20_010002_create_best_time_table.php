<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('best_time', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en', 255)->nullable();
            $table->string('title_de', 255)->nullable();
            $table->text('intro_en')->nullable();
            $table->text('intro_de')->nullable();
            $table->index('title_en', 'idx_best_time_title_en');
            $table->index('title_de', 'idx_best_time_title_de');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('best_time');
    }
};

