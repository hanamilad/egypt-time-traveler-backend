<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SocialVideo;
use Illuminate\Http\Request;

class SocialVideoController extends Controller
{
    public function index()
    {
        $videos = SocialVideo::where('is_active', true)
            ->where('platform', 'youtube')
            ->get();

        return response()->json([
            'data' => $videos,
        ]);
    }
}
