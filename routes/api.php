<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
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

//auth sanctum->utk user dah login shj, dah dapat token
Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/main', [AuthenticationController::class, 'main']);
    Route::post('/posts', [PostController::class, 'store']); //create POST
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware('writer'); //update POST
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('writer'); //delete POST

    Route::post('/comments', [CommentController::class, 'store']); //create COMMENT
    Route::patch('/comments/{id}', [CommentController::class, 'update'])->middleware('commentator');//update COMMENT
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('commentator'); //delete COMMENT
    
    
});


Route::get('/posts', [PostController::class, 'index']); 
Route::get('/posts/{id}', [PostController::class, 'show']);
// Route::get('/posts2/{id}', [PostController::class, 'show2']);


Route::post('/login', [AuthenticationController::class, 'login']);

