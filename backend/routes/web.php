<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return file_get_contents(public_path('index.html'));
});

Route::get('/js/properties.js', [PropertyController::class, 'getPropertiesJs']);

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Panel Action Routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/properties', [AdminController::class, 'storeProperty']);
Route::delete('/admin/properties/{id}', [AdminController::class, 'destroyProperty']);


