<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiTiketController;
use App\Http\Controllers\Api\ApiKategoriController;
use App\Http\Controllers\Api\ApiAuthController;
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


Route::resource('categories', ApiKategoriController::class);
Route::resource('tikets', ApiTiketController::class);
Route::resource('events', ApiEventController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get("my-profile",  [ApiUserController::class, 'getUserByToken']);
    Route::prefix('users')->group(function () {
        Route::get('/', [ApiUserController::class, 'getAllUsers']);
        Route::get('/{user_id}', [ApiUserController::class, 'getUser']);
        Route::put('/{user_id}', [ApiUserController::class, 'updateUser']);
    });
    Route::get('/logout', [ApiAuthController::class, 'logout']);

    Route::prefix('events')->group(function () {
        Route::post('/', [ApiEventController::class, 'createEvent']);
        Route::put('/{event_id}', [ApiEventController::class, 'updateEvent']);
        Route::delete('/{event_id}', [ApiEventController::class, 'deleteEvent']);
    });

    Route::prefix('checkouts')->group(function () {
        Route::get('/', [ApiCheckoutController::class, 'getAllCheckouts']);
        Route::post('/', [ApiCheckoutController::class, 'createCheckout']);
        Route::get('/{checkout_id}', [ApiCheckoutController::class, 'getCheckout']);
        Route::put('/{checkout_id}', [ApiCheckoutController::class, 'updateCheckout']);
        Route::get('/{checkout_id}/orders', [ApiOrderController::class, 'getAllOrders']);
        
    });
    Route::post('/orders', [ApiOrderController::class, 'createOrder']);
});

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);