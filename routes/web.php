<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loggedIn'])->middleware('active')->name('login.store');
Route::post('/register', [AuthController::class, 'registerp'])->name('register.store');
Route::middleware(['auth', 'active', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn () => view('dashboards.admin'))->name('admin.dashboard');
    });

Route::middleware(['auth', 'active', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', fn () => view('dashboards.user')) ->name('user.dashboard');
    });
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');