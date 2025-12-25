<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 255)->unique();
            $table->enum('city', ['cairo', 'luxor', 'aswan', 'alexandria', 'hurghada']);
            $table->string('title_en', 255);
            $table->string('title_de', 255);
            $table->text('short_desc_en');
            $table->text('short_desc_de');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->integer('duration_hours');
            $table->integer('max_group')->default(12);
            $table->decimal('rating', 2, 1)->default(0);
            $table->integer('review_count')->default(0);
            $table->boolean('featured')->default(false);
            $table->string('image', 500);
            $table->string('category')->nullable(); // history, adventure, culture, etc.
            $table->enum('status', ['active', 'draft', 'archived'])->default('active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index('city', 'tours_city_index');
            $table->index('featured', 'tours_featured_index');
            $table->index('status', 'tours_status_index');
            $table->index('price', 'tours_price_index');
            $table->index('rating', 'tours_rating_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};

