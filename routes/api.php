<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiTiketController;
use App\Http\Controllers\Api\ApiCheckoutController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiOrderController;

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

Route::prefix('events')->group(function () {
    Route::get('/trending', [ApiEventController::class, 'getAllEventsTrending']);
    Route::get('', [ApiEventController::class, 'getAllEvents']);
    Route::get('/{event_id}', [ApiEventController::class, 'getEvent']);

    // Ticket
    Route::prefix('{event_id}/tickets')->group(function () {
        Route::get('', [ApiTiketController::class, 'getAllTickets']);
    });
});


Route::prefix('tickets')->group(function () {
    Route::get('/{ticket_id}', [ApiTiketController::class, 'getTicket']);
});



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get("my-profile",  [ApiUserController::class, 'getUserByToken']);
    Route::put('update-user-active', [ApiUserController::class, 'updateUserActive']);
    Route::prefix('users')->group(function () {
        Route::put('/change-password', [ApiUserController::class, 'updatePassword']);
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