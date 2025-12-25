<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'slug' => $this->slug,
            'city' => $this->city,
            'title_en' => $this->title_en,
            'title_de' => $this->title_de,
            'short_desc_en' => $this->short_desc_en,
            'short_desc_de' => $this->short_desc_de,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'child_discount_percent' => $this->child_discount_percent,
            'duration_hours' => $this->duration_hours,
            'duration_days' => $this->duration_days,
            'max_group' => $this->max_group,
            'rating' => $this->rating,
            'review_count' => $this->review_count,
            'featured' => $this->featured,
            'image' => $this->image_url,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->relationLoaded('details') && $this->details) {
            $details = $this->details->toArray();
            unset($details['id']);
            unset($details['created_at']);
            unset($details['updated_at']);
            
            $data = array_merge($data, $details);
        }

        $data['itineraries'] = $this->whenLoaded('itineraries');
        $data['images'] = TourImageResource::collection($this->whenLoaded('images'));
        $data['faqs'] = $this->whenLoaded('faqs');
        $data['reviews'] = $this->whenLoaded('reviews');
        $data['pricings'] = $this->whenLoaded('pricings');
        $data['availabilities'] = $this->whenLoaded('availabilities');

        return $data;
    }
}
