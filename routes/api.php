<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::resource('news', NewsController::class);
    Route::get('newsDec', [NewsController::class, 'getAllByOrderDesc']);
    Route::post('createCategory',[CategoryController::class, 'store']);
    Route::get('categories',[CategoryController::class, 'index']);
    Route::get('newsByCategoryId/{category}',[CategoryController::class, 'getNewsByCategoryId']);
    Route::get('newsByCategoryName/{category}',[CategoryController::class, 'getNewsByCategoryName']);
});

