<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactLeadController;
use App\Http\Controllers\Api\TravelInfoController;


Route::post('/contact-leads', [ContactLeadController::class, 'store']);
Route::get('/travel-info', [TravelInfoController::class, 'show']);
Route::get('/social-videos', [\App\Http\Controllers\Api\SocialVideoController::class, 'index']);
Route::get('/site-info', [\App\Http\Controllers\Api\SiteInfoController::class, 'index']);

// Cities
Route::get('/cities', [\App\Http\Controllers\Api\CityController::class, 'index']);
Route::get('/cities/{id}', [\App\Http\Controllers\Api\CityController::class, 'show']);

// Tours
Route::get('/tours', [\App\Http\Controllers\Api\TourController::class, 'index']);
Route::get('/packages', [\App\Http\Controllers\Api\PackageController::class, 'index']);
Route::get('/offers/featured', [\App\Http\Controllers\Api\OfferController::class, 'featured']);
Route::get('/tours/{slug}', [\App\Http\Controllers\Api\TourController::class, 'show']);
Route::get('/tours/{slug}/availability', [\App\Http\Controllers\Api\TourController::class, 'availability']);
Route::post('/tours/{slug}/reviews', [\App\Http\Controllers\Api\TourReviewController::class, 'store']);

// Bookings
Route::post('/bookings/create', [\App\Http\Controllers\Api\BookingController::class, 'store']);
