<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 50)->nullable();
            $table->unsignedInteger('adults')->default(1);
            $table->unsignedInteger('children')->default(0);
            $table->enum('interest', ['day-tours', 'nile-cruises', 'holiday-packages', 'custom'])->nullable();
            $table->text('message');
            $table->enum('status', ['new', 'in_progress', 'resolved'])->default('new');
            $table->timestamps();

            $table->index('status', 'idx_status');
            $table->index('email', 'idx_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_leads');
    }
};

