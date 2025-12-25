<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('best_time_id')->nullable();
            $table->enum('season_name', ['winter','spring','summer','fall'])->nullable();
            $table->string('name_en', 255)->nullable();
            $table->string('name_de', 255)->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->foreign('best_time_id')->references('id')->on('best_time');
            $table->index('best_time_id', 'idx_seasons_best_time');
            $table->index('season_name', 'idx_seasons_name');
            $table->unique(['best_time_id', 'season_name'], 'uniq_best_time_season');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};

