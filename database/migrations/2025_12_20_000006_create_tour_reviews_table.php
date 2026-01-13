<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_id');
            $table->string('author', 100);
            $table->string('country', 100)->nullable();
            $table->unsignedTinyInteger('rating');
            $table->text('comment');
            $table->date('date');
            $table->string('avatar', 500)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->index(['tour_id', 'status'], 'idx_tour_status');
            $table->index('rating', 'idx_rating');
        });
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE `tour_reviews` ADD CONSTRAINT `chk_rating` CHECK (rating >= 1 AND rating <= 5)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_reviews');
    }
};
