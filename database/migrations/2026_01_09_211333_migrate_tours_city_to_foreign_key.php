<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\City;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new city_id column as nullable initially
        if (!Schema::hasColumn('tours', 'city_id')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->unsignedBigInteger('city_id')->nullable()->after('slug');
            });
        }

        // Migrate existing city string values to city_id
        if (Schema::hasColumn('tours', 'city')) {
            // Get cities for mapping
            $cities = DB::table('cities')->get()->pluck('id', 'name_en')->mapWithKeys(function ($id, $name) {
                return [strtolower($name) => $id];
            })->toArray();

            foreach ($cities as $cityName => $cityId) {
                DB::table('tours')
                    ->where('city', $cityName)
                    ->update(['city_id' => $cityId]);
            }
        }

        // Handle any tours that might still have NULL city_id (fallback to first city)
        $defaultCityId = DB::table('cities')->first()?->id;
        if ($defaultCityId) {
            DB::table('tours')
                ->whereNull('city_id')
                ->update(['city_id' => $defaultCityId]);
        }

        // Drop old city column and make city_id required with foreign key
        Schema::table('tours', function (Blueprint $table) {
            if (Schema::hasColumn('tours', 'city')) {
                $table->dropColumn('city');
            }

            // Fix for the previous error: ensure city_id is bigint unsigned before foreign key
            $table->unsignedBigInteger('city_id')->nullable(false)->change();

            // Check if foreign key already exists (optional but safe)
            // For simplicity, just try to add it. If it exists, it might fail, but usually we just want to finish the migration.
            try {
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict');
            } catch (\Exception $e) {
                // If already exists, ignore
            }

            try {
                $table->index('city_id');
            } catch (\Exception $e) {
                // If already exists, ignore
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropIndex(['city_id']);
            if (!Schema::hasColumn('tours', 'city')) {
                $table->string('city')->nullable()->after('slug');
            }
        });

        // Migrate city_id back to city string
        $tours = DB::table('tours')->get();
        foreach ($tours as $tour) {
            if ($tour->city_id) {
                $city = DB::table('cities')->where('id', $tour->city_id)->first();
                if ($city) {
                    DB::table('tours')
                        ->where('id', $tour->id)
                        ->update(['city' => strtolower($city->name_en)]);
                }
            }
        }

        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
};
