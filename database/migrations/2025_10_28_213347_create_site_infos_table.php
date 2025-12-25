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
    Schema::create('site_infos', function (Blueprint $table) {
        $table->id();
        $table->string('brand1');
        $table->string('brand2');
        $table->string('tagline')->nullable();
        $table->string('address')->nullable();    // [ {type, city, country, address_line, lat, lng}, ... ]
        $table->string('phone')->nullable();       // [ {type, number, label, preferred}, ... ]
        $table->string('email')->nullable(); 
        $table->string('availability')->nullable();//24/7 Available
        $table->json('social_links')->nullable(); // { facebook, instagram, twitter, linkedin, youtube, ... }
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_infos');
    }
};
