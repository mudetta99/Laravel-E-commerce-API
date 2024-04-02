<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassposrtAuthController;
use App\Http\Controllers\ProductController;

// Routes for user authentication

// Route for user registration
Route::post('register', [PassposrtAuthController::class, 'register']); 
// Route for user login
Route::post('login', [PassposrtAuthController::class, 'login']); 

// Routes for authenticated users
Route::middleware('auth:api')->group(function () {
    // Route to get user information
    Route::get('userinfo', [PassposrtAuthController::class, 'userInfo']); 
    // Resource route for products CRUD operations
    Route::resource('products', ProductController::class); 
});
