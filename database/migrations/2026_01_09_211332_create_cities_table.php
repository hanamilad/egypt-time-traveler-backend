<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->unique();
            $table->string('name_de');
            $table->timestamps();
        });

        // Seed initial cities
        DB::table('cities')->insert([
            ['name_en' => 'Cairo', 'name_de' => 'Kairo', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Luxor', 'name_de' => 'Luxor', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Aswan', 'name_de' => 'Assuan', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Alexandria', 'name_de' => 'Alexandria', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Hurghada', 'name_de' => 'Hurghada', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
