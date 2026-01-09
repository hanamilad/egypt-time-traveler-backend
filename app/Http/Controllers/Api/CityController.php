<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Resources\CityResource;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::withCount('tours')
            ->orderBy('name_en')
            ->get();

        return CityResource::collection($cities);
    }

    public function show($id)
    {
        $city = City::withCount('tours')->findOrFail($id);

        return new CityResource($city);
    }
}
