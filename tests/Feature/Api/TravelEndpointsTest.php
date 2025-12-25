<?php

namespace Tests\Feature\Api;

use App\Models\Offer;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_packages()
    {
        Tour::factory()->create([
            'title_en' => 'Test Package',
            'duration_days' => 5,
            'status' => 'active'
        ]);

        $response = $this->get('/api/packages');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.title_en', 'Test Package')
            ->assertJsonPath('data.0.duration_days', 5);
    }



    public function test_can_get_featured_offers()
    {
        Offer::create([
            'title_en' => 'Special Offer',
            'title_de' => 'Sonderangebot',
            'end_date' => now()->addDays(5),
            'target_link' => '/test-link',
            'image' => 'test.jpg',
            'active' => true
        ]);

        $response = $this->get('/api/offers/featured');

        $response->assertStatus(200)
            ->assertJsonPath('data.title_en', 'Special Offer');
    }

    public function test_can_get_featured_tours()
    {
        Tour::factory()->create([
            'featured' => true,
            'title_en' => 'Featured Tour',
            'status' => 'active'
        ]);

        $response = $this->get('/api/tours?featured=true');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.title_en', 'Featured Tour');
    }
}
