<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\Organizer\AuthController;
use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\Organizer\OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController as EventOrganizerController;
use App\Http\Controllers\Organizer\CategoryController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PublicAuthController;



// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout', [EventController::class,'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/organizers/{organization}', [OrganizerController::class, 'show'])->name('organizers.show');

// Rute publik auth untuk End User
Route::get('/login', [PublicAuthController::class, 'showLoginUser'])->name('login');
Route::post('/login', [PublicAuthController::class, 'loginUser'])->name('login.post');
Route::get('/register', [PublicAuthController::class, 'showRegisterUser'])->name('register');
Route::post('/register', [PublicAuthController::class, 'registerUser'])->name('register.post');

// Rute publik auth untuk Organizer
Route::get('/login/organizer', [PublicAuthController::class, 'showLoginOrganizer'])->name('organizer_auth.login');
Route::post('/login/organizer', [PublicAuthController::class, 'loginOrganizer'])->name('organizer_auth.login.post');
Route::get('/register/organizer', [PublicAuthController::class, 'showRegisterOrganizer'])->name('organizer_auth.register');
Route::post('/register/organizer', [PublicAuthController::class, 'registerOrganizer'])->name('organizer_auth.register.post');

Route::post('/logout', [PublicAuthController::class, 'logout'])->name('logout');

Route::prefix('organizer')->name('organizer.')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Mengamankan area organizer di balik middleware
    Route::middleware(['auth', 'organizer'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('dashboard', [OrganizerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', EventOrganizerController::class);
        Route::resource('partners', \App\Http\Controllers\PartnerController::class);
        Route::resource('categories', CategoryController::class)->except('show');
        Route::get('transactions', [\App\Http\Controllers\Organizer\TransactionController::class, 'index'])->name('transactions.index');
    });
});

Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');