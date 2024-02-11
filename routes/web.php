<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\listingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// get all listings
Route::get('/',[listingController::class,'index']);

// show create form
Route::get('/listings/create',[listingController::class,'create'])->middleware('auth');

// store listing data
Route::post('/listings',[listingController::class,'store'])->middleware('auth');

// show edit form
Route::get('/listings/{listing}/edit',[listingController::class,'edit'])->middleware('auth');


// update listing
Route::put('/listings/{listing}',[listingController::class,'update'])->middleware('auth');

// delete listing
Route::delete('/listings/{listing}',[listingController::class,'destroy'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage',[listingController::class,'manage'])->middleware('auth');

// get single listing
Route::get('/listings/{listing}',[listingController::class,'show']);

// show register create form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

// create new user
Route::post('/users',[UserController::class,'store']);

 //log user out
 Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//show login form 
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

// log in user
Route::post('/users/authenticate',[UserController::class,'authenticate'])->middleware('auth');





