<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Http\Resources\TourResource;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Tour::with('city')
            ->packages()
            ->active()
            ->paginate(20);

        return TourResource::collection($packages);
    }
}
