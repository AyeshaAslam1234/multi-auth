<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\EmailController;
use App\Http\Middleware\redirectIfAuthenticated;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Auth\GitHubController;
use App\Http\Controllers\Auth\GoogleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard (protected)
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');
    
    // Keep logout as GET
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin_logout');
});

// Login routes (for guests)
Route::middleware('admin.redirectIfAuthenticated')->prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin_login');
    Route::post('/login-submit', [AdminController::class, 'login_submit'])->name('admin_login_submit');
});
//  Route::get('send-email',[EmailController::class, 'sendemail']);


  Route::get('/stripe', [StripeController::class, 'index'])->name('payment.form');
Route::post('/checkout', [StripeController::class, 'checkout'])->name('payment.checkout');

// web.php
Route::get('/stripe/success-redirect', function () {
    return redirect()->route('payment.form')->with('success', 'Payment Successful!');
});


Route::get('/cancel', function () {
    return "Payment Canceled!";
})->name('payment.cancel');
            
require __DIR__.'/auth.php';

//laravel-socialite

Route::get('auth/github/redirect', [GitHubController::class, 'redirectToGitHub'])->name('github.redirect');
Route::get('auth/github/callback', [GitHubController::class, 'handleGitHubCallback'])->name('github.callback');


// Google login
Route::get('auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

