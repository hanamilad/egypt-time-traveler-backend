<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'city' => $this->faker->randomElement(['cairo', 'luxor', 'aswan', 'alexandria', 'hurghada']),
            'title_en' => $this->faker->sentence,
            'title_de' => $this->faker->sentence,
            'short_desc_en' => $this->faker->paragraph,
            'short_desc_de' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 50, 500),
            'original_price' => $this->faker->randomFloat(2, 500, 1000),
            'duration_hours' => $this->faker->numberBetween(4, 12),
            'duration_days' => $this->faker->numberBetween(1, 14),
            'max_group' => $this->faker->numberBetween(5, 20),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'review_count' => $this->faker->numberBetween(0, 100),
            'featured' => $this->faker->boolean,
            'image' => $this->faker->imageUrl,

            'status' => 'active',
            'port' => null,
        ];
    }
}
