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
        Schema::table('site_infos', function (Blueprint $table) {
            $table->longText('booking_policy_en')->nullable();
            $table->longText('booking_policy_de')->nullable();
            $table->longText('cancellation_policy_en')->nullable();
            $table->longText('cancellation_policy_de')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_infos', function (Blueprint $table) {
            $table->dropColumn([
                'booking_policy_en',
                'booking_policy_de',
                'cancellation_policy_en',
                'cancellation_policy_de',
            ]);
        });
    }
};
