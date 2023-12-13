<?php

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactQueryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AllUserController;


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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


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



// Registration
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // User update
    Route::put('/user/{id}', [AuthController::class, 'update']);
});


Route::resource('all_users', AllUserController::class);