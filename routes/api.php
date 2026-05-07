<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    //ping route
    Route::get('/', function () {
        return response()->json([
            'status' => "success",
            'data' => "pong",
            'message' => "success"
        ], 200);
    });

    // Dummy route for Midtrans SDK initialization
    Route::get('/charge', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Midtrans initialization dummy endpoint'
        ]);
    });
    Route::post('/charge', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Midtrans initialization dummy endpoint'
        ]);
    });

    // auth route
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // midtrans webhook
    Route::post('/bookings/webhook', [BookingController::class, 'webhook']);

    Route::middleware('auth:sanctum')->group(function () {

        // auth route
        Route::post('/logout', [AuthController::class, 'logout']);

        // users route
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::get('/users/me', [UserController::class, 'me']);

        // event route
        Route::get('/events', [EventController::class, 'index']);
        Route::post('/events', [EventController::class, 'store']);
        Route::get('/events/{id}', [EventController::class, 'show']);
        Route::put('/events/{id}', [EventController::class, 'update']);
        Route::delete('/events/{id}', [EventController::class, 'destroy']);

        // booking route
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::get('/bookings/{id}', [BookingController::class, 'show']);
        Route::put('/bookings/{id}', [BookingController::class, 'update']);
        Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    });
});