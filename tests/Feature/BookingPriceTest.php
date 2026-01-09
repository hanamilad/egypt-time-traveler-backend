<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\TourPricing;
use App\Models\TourAvailability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingPriceTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_pricing_calculation()
    {
        $city = \App\Models\City::updateOrCreate(
            ['slug' => 'cairo'],
            ['name_en' => 'Cairo', 'name_de' => 'Kairo']
        );

        $tour = Tour::create([
            'title_en' => 'Test Tour',
            'title_de' => 'Test Tour DE',
            'slug' => 'test-tour',
            'city_id' => $city->id,
            'price' => 100.00,
            'child_discount_percent' => 50, // 50$ for child
            'status' => 'active',
            'image' => 'test.jpg',
            'duration_hours' => 5
        ]);

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            'date' => now()->addDays(5)->toDateString(),
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'adults' => 2,
            'children' => 1,
        ]);

        $response->assertStatus(201);
        $this->assertEquals(250.00, $response->json('booking_id') ? \App\Models\Booking::find($response->json('booking_id'))->total_price : 0);
    }

    public function test_tiered_pricing_overrides_default()
    {
        $city = \App\Models\City::updateOrCreate(
            ['slug' => 'cairo'],
            ['name_en' => 'Cairo', 'name_de' => 'Kairo']
        );

        $tour = Tour::create([
            'title_en' => 'Tiered Tour',
            'title_de' => 'Tiered Tour DE',
            'slug' => 'tiered-tour',
            'city_id' => $city->id,
            'price' => 100.00,
            'child_discount_percent' => 0,
            'status' => 'active',
            'image' => 'test.jpg',
            'duration_hours' => 5
        ]);

        // Tiered price for 3 people: $210 total ($70 per person)
        TourPricing::create([
            'tour_id' => $tour->id,
            'people_count' => 3,
            'price' => 210.00
        ]);

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            'date' => now()->addDays(5)->toDateString(),
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'adults' => 3,
            'children' => 0,
        ]);

        $response->assertStatus(201);
        $booking = \App\Models\Booking::find($response->json('booking_id'));
        $this->assertEquals(210.00, $booking->total_price);
    }

    public function test_special_date_pricing()
    {
        $city = \App\Models\City::updateOrCreate(
            ['slug' => 'cairo'],
            ['name_en' => 'Cairo', 'name_de' => 'Kairo']
        );

        $tour = Tour::create([
            'title_en' => 'Special Date Tour',
            'title_de' => 'Special Date Tour DE',
            'slug' => 'special-date-tour',
            'city_id' => $city->id,
            'price' => 100.00,
            'child_discount_percent' => 0,
            'status' => 'active',
            'image' => 'test.jpg',
            'duration_hours' => 5
        ]);

        $specialDate = now()->addDays(10)->toDateString();

        TourAvailability::create([
            'tour_id' => $tour->id,
            'date' => $specialDate,
            'available_seats' => 10,
            'special_price' => 150.00,
            'status' => 'available'
        ]);

        $response = $this->postJson('/api/bookings', [
            'tour_id' => $tour->id,
            'date' => $specialDate,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'adults' => 2,
            'children' => 0,
        ]);

        $response->assertStatus(201);
        $booking = \App\Models\Booking::find($response->json('booking_id'));
        $this->assertEquals(300.00, $booking->total_price);
    }
}
