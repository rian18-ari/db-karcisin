<?php

use App\Http\Controllers\WebAuthController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Public Routes
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth Routes
Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Owner Routes
Route::middleware('auth.owner')->prefix('owner')->name('owner.')->group(function () {
    Volt::route('/dashboard', 'owner.⚡dashboard')->name('dashboard');
    Volt::route('/events/create', 'owner.events.⚡create-event')->name('events.create');
    Volt::route('/participants', 'owner.⚡participants')->name('bookings.index');
    Volt::route('/events/{id}', 'owner.events.⚡event-detail')->name('event.detail');
});