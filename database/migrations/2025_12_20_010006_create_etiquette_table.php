<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etiquette', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en', 255)->nullable();
            $table->string('title_de', 255)->nullable();
            $table->text('intro_en')->nullable();
            $table->text('intro_de')->nullable();
            $table->index('title_en', 'idx_etiquette_title_en');
            $table->index('title_de', 'idx_etiquette_title_de');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etiquette');
    }
};

