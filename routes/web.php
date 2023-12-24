<?php

use Illuminate\Support\Facades\Route;
use App\Models\Listing;

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

//всі лісти
Route::get('/',  [\App\Http\Controllers\ListngController::class, 'index']);



// показ створення форми

Route::get('/listings/create',  [\App\Http\Controllers\ListngController::class, 'create'])->middleware('auth');

//store listing data

Route::post('/listings', [\App\Http\Controllers\ListngController::class,'store']);


//показ відредагувані форми
Route::get('/listings/{listing}/edit',[Listing::class,'edit']);

//сабміт оновлення форми кароче апдейчу Listings
Route::put('/listings/{listing}', [\App\Http\Controllers\ListngController::class, 'update']);

//удаляю карточку
Route::delete('/listings/{listing}', [\App\Http\Controllers\ListngController::class, 'destroy']);

//одиночні лісти

Route::get('/listings/{listing}', [\App\Http\Controllers\ListngController::class,'show']);

//show Register/create form
Route::get('/register', [\App\Http\Controllers\UserController::class,'create']);

//створення юзера
Route::post('/users',[\App\Http\Controllers\UserController::class, 'store']);

//розлогінізація
Route::post('/logout', [\App\Http\Controllers\UserController::class,'logout']);

//показ форми логіна
Route::get('/login',[\App\Http\Controllers\UserController::class,'login']);

//логін юзера
Route::post('/users/authenticate', [\App\Http\Controllers\UserController::class,'authenticate']);
