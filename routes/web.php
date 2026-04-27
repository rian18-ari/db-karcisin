<?php

use App\Http\Controllers\Owner\EventController;
use App\Http\Controllers\WebAuthController;
use App\Models\event;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    $events = event::where('status', 'published')->latest()->take(6)->get();
    return view('landing', compact('events'));
})->name('landing');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);
});

Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Owner Routes
Route::middleware('auth.owner')->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', function () {
        return view('owner.dashboard');
    })->name('dashboard');

    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    Route::get('/participants', [EventController::class, 'participants'])->name('bookings.index');
    Route::post('/bookings/{id}/check-in', [EventController::class, 'checkIn'])->name('bookings.checkin');
});