<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactQueryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Register API routes for your application. These routes are loaded by
| the RouteServiceProvider and assigned to the "api" middleware group.
|
*/

// Authenticated User Route (Example)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Testimonials Routes
Route::resource('testimonials', TestimonialController::class);

// FAQ Categories Routes
Route::resource('faq-categories', FaqCategoryController::class);

// FAQs Routes
Route::resource('faqs', FaqController::class);

// Product Categories Routes
Route::resource('product-categories', ProductCategoryController::class);

// Products Routes
Route::resource('products', ProductController::class);

// Contact Queries Routes
Route::resource('contact-queries', ContactQueryController::class);
