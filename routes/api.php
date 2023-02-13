<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//auth sanctum->utk user dah login shj
Route::get('/posts', [PostController::class, 'index'])->middleware(['auth:sanctum']); 
Route::get('/posts/{id}', [PostController::class, 'show'])->middleware(['auth:sanctum']);
// Route::get('/posts2/{id}', [PostController::class, 'show2']);

Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/logout', [AuthenticationController::class, 'logout'])->middleware(['auth:sanctum']);
Route::get('/main', [AuthenticationController::class, 'main'])->middleware(['auth:sanctum']);
