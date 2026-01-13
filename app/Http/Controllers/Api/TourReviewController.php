<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TourReview;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TourReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tourSlug
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $tourSlug)
    {
        // 1. Validate the tour exists
        $tour = Tour::where('slug', $tourSlug)->first();

        if (!$tour) {
            return response()->json([
                'message' => 'Tour not found.'
            ], 404);
        }

        // 2. Validate input
        $validated = $request->validate([
            'author' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'country' => 'nullable|string|max:100',
            'photos' => 'nullable|array|max:5', // Max 5 photos
            'photos.*' => 'image|max:2048', // 2MB Max per photo
        ]);

        // 3. Create Review
        $review = TourReview::create([
            'tour_id' => $tour->id,
            'author' => $validated['author'],
            'country' => $validated['country'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'], // Assuming default to EN for now
            'date' => now(),
            'status' => 'approved',
        ]);

        // 4. Handle Photos Upload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews/photos', 'public');
                $review->photos()->create([
                    'path' => $path
                ]);
            }
        }

        // 5. Load photos for response
        $review->load('photos');

        // 6. Return success response
        return response()->json([
            'message' => 'Review submitted successfully.',
            'data' => $review
        ], 201);
    }
}
