<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects/{project:slug}', [HomeController::class, 'show'])->name('projects.show');
Route::post('/contact', [HomeController::class, 'contact'])->middleware('throttle:contact')->name('contact');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('account', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('account', [AccountController::class, 'update'])->middleware('throttle:account')->name('account.update');

    Route::resource('projects', ProjectController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except(['show', 'create']);
    Route::resource('skills', SkillController::class)->except(['show', 'create']);
    Route::resource('experiences', ExperienceController::class)->except('show');

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::patch('messages/{message}/read', [MessageController::class, 'read'])->name('messages.read');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
