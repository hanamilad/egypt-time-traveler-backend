<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packing_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('packing_id')->nullable();
            $table->string('name_en', 255)->nullable();
            $table->string('name_de', 255)->nullable();
            $table->json('items_en')->nullable();
            $table->json('items_de')->nullable();
            $table->foreign('packing_id')->references('id')->on('packing');
            $table->index('packing_id', 'idx_packing_categories_packing');
            $table->index('name_en', 'idx_packing_categories_name_en');
            $table->index('name_de', 'idx_packing_categories_name_de');
            $table->unique(['packing_id', 'name_en'], 'uniq_packing_category_en');
            $table->unique(['packing_id', 'name_de'], 'uniq_packing_category_de');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packing_categories');
    }
};

