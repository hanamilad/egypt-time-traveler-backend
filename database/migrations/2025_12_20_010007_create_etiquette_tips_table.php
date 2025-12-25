<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etiquette_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('etiquette_id')->nullable();
            $table->string('title_en', 255)->nullable();
            $table->string('title_de', 255)->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_de')->nullable();
            $table->foreign('etiquette_id')->references('id')->on('etiquette');
            $table->index('etiquette_id', 'idx_etiquette_tips_etiquette');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etiquette_tips');
    }
};

