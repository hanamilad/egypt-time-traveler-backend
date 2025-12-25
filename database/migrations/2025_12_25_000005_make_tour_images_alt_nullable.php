<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tour_images', function (Blueprint $table) {
            $table->string('alt_en', 255)->nullable()->change();
            $table->string('alt_de', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_images', function (Blueprint $table) {
            $table->string('alt_en', 255)->nullable(false)->change();
            $table->string('alt_de', 255)->nullable(false)->change();
        });
    }
};
