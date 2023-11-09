<?php


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
use App\Http\Controllers\Api\EmateraiController;
// Route::resource('/ematerai', EmateraiController::class)->middleware('auth');
// Route::resource('/ematerai', EmateraiController::class)->middleware('auth');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth')->get('/', function (Request $request) {
//     Route::resource('/ematerai', EmateraiController::class)->middleware('auth');
// });
Route::resource('/ematerai', EmateraiController::class)->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::resource('/ematerai', EmateraiController::class)->middleware('auth');
    // Route::get('/ematerai', function (Request $request) {});
 
    Route::get('/user/profile', function () {
        // Uses first & second middleware...
    });
});

