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
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('port');
        });

        Schema::table('tour_details', function (Blueprint $table) {
            $table->dropColumn(['meeting_point', 'map_lat', 'map_lng']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->string('port')->nullable()->after('duration_days');
        });

        Schema::table('tour_details', function (Blueprint $table) {
            $table->string('meeting_point', 500)->nullable();
            $table->decimal('map_lat', 10, 7)->nullable();
            $table->decimal('map_lng', 10, 7)->nullable();
        });
    }
};
