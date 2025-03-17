<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    
// Books
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/{slug}', [BookController::class, 'show'])->name('show');
    
    // Protected routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/{slug}/read', [BookController::class, 'read'])->name('read');
        Route::post('/{id}/rating', [BookController::class, 'storeRating'])->name('store-rating');
        Route::post('/{id}/reading-progress', [BookController::class, 'updateReadingProgress'])->name('update-progress');
    });
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('index');
        Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('update-profile');
        Route::get('/change-password', [UserDashboardController::class, 'changePassword'])->name('change-password');
        Route::put('/change-password', [UserDashboardController::class, 'updatePassword'])->name('update-password');
        Route::get('/reading-history', [UserDashboardController::class, 'readingHistory'])->name('reading-history');
        Route::get('/borrow-history', [UserDashboardController::class, 'borrowHistory'])->name('borrow-history');
        Route::get('/penalty-history', [UserDashboardController::class, 'penaltyHistory'])->name('penalty-history');
    });

    // Add this alias route outside the group
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Book borrows
    Route::prefix('borrows')->name('borrows.')->group(function () {
        Route::get('/', [BorrowController::class, 'index'])->name('index');
        Route::get('/create/{book_id?}', [BorrowController::class, 'create'])->name('create');
        Route::post('/', [BorrowController::class, 'store'])->name('store');
        Route::post('/{id}/return', [BorrowController::class, 'return'])->name('return');
    });
    
    // Penalties
    Route::prefix('penalties')->name('penalties.')->group(function () {
        Route::get('/', [PenaltyController::class, 'index'])->name('index');
        Route::post('/{id}/upload-receipt', [PenaltyController::class, 'uploadReceipt'])->name('upload-receipt');
    });
});

// Admin routes (perlu role admin atau librarian)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Admin routes akan ditangani oleh Laravel Filament
    // Akses ke /admin akan mengarah ke panel admin Filament
});