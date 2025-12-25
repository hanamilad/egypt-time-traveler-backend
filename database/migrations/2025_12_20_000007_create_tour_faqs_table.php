<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_id');
            $table->text('question_en');
            $table->text('question_de');
            $table->text('answer_en');
            $table->text('answer_de');
            $table->integer('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->index(['tour_id', 'sort_order'], 'tour_faqs_sort_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_faqs');
    }
};

