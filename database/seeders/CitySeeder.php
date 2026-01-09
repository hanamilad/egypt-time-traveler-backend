<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name_en' => 'Cairo',
                'name_de' => 'Kairo',
            ],
            [
                'name_en' => 'Luxor',
                'name_de' => 'Luxor',
            ],
            [
                'name_en' => 'Aswan',
                'name_de' => 'Assuan',
            ],
            [
                'name_en' => 'Alexandria',
                'name_de' => 'Alexandria',
            ],
            [
                'name_en' => 'Hurghada',
                'name_de' => 'Hurghada',
            ],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
