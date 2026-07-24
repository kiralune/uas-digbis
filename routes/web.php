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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout', [EventController::class,'checkout'])->name('checkout');
Route::middleware('auth')->group(function () {
    Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
});
Route::get('/organizers/{organizer}', [OrganizerController::class, 'show'])->name('organizers.show');
Route::get('/review/{transaction:order_id}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/review/{transaction:order_id}', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/review/{transaction:order_id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
Route::patch('/review/{transaction:order_id}', [ReviewController::class, 'update'])->name('reviews.update');

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
Route::get('/profile', [\App\Http\Controllers\UserProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::patch('/profile', [\App\Http\Controllers\UserProfileController::class, 'update'])->middleware('auth')->name('profile.update');

Route::get('/login/admin', [PublicAuthController::class, 'showLoginAdmin'])->name('admin_auth.login');
Route::post('/login/admin', [PublicAuthController::class, 'loginAdmin'])->name('admin_auth.login.post');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/organizers', [AdminController::class, 'organizers'])->name('organizers.index');
        Route::get('/organizers/{organization}', [AdminController::class, 'showOrganizer'])->name('organizers.show');
        Route::post('/organizers/{organization}/verify', [AdminController::class, 'verifyOrganizer'])->name('organizers.verify');
        Route::get('/events', [AdminController::class, 'events'])->name('events.index');
        Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions.index');

        Route::get('/partners', [AdminController::class, 'partners'])->name('partners.index');
        Route::get('/partners/create', [AdminController::class, 'createPartner'])->name('partners.create');
        Route::post('/partners', [AdminController::class, 'storePartner'])->name('partners.store');
        Route::get('/partners/{partner}/edit', [AdminController::class, 'editPartner'])->name('partners.edit');
        Route::put('/partners/{partner}', [AdminController::class, 'updatePartner'])->name('partners.update');
        Route::delete('/partners/{partner}', [AdminController::class, 'destroyPartner'])->name('partners.destroy');

        Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
        Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
        Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    });
});

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
        Route::get('profile/edit', [\App\Http\Controllers\Organizer\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [\App\Http\Controllers\Organizer\ProfileController::class, 'update'])->name('profile.update');
        Route::resource('events', EventOrganizerController::class);
        Route::get('transactions', [\App\Http\Controllers\Organizer\TransactionController::class, 'index'])->name('transactions.index');
        Route::post('transactions/{transaction}/mark-attendance', [\App\Http\Controllers\Organizer\TransactionController::class, 'markAttendance'])->name('transactions.mark-attendance');
    });
});

Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// Redirect unknown routes to home so no page shows 404 by default
Route::fallback(function () {
    return redirect()->route('home');
});