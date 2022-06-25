<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\ProductController;


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

Route::post('register', [Auth::class, 'register']);
Route::post('login', [Auth::class, 'login']);
  
Route::middleware('auth:api')->group(function () {
    Route::get('get-user', [Auth::class, 'userInfo']);
    Route::post('store', [StoreController::class, 'store']);
    Route::post('setting', [SettingController::class, 'store']);
    Route::post('product', [ProductController::class, 'store']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
