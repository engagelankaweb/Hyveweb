<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return file_get_contents(base_path('../index.html'));
});

Route::get('/{page}.html', function ($page) {
    $path = base_path('../' . basename($page) . '.html');
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    abort(404);
});

Route::get('/js/properties.js', [PropertyController::class, 'getPropertiesJs']);

// Admin Login & Authentication Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Dashboard & User Profile
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

// Admin Property Management Routes
Route::get('/admin/properties/{id}', [AdminController::class, 'getProperty'])->name('admin.properties.get');
Route::post('/admin/properties', [AdminController::class, 'storeProperty'])->name('admin.properties.store');
Route::post('/admin/properties/{id}', [AdminController::class, 'updateProperty'])->name('admin.properties.update');
Route::put('/admin/properties/{id}', [AdminController::class, 'updateProperty']);
Route::delete('/admin/properties/{id}', [AdminController::class, 'destroyProperty'])->name('admin.properties.destroy');
Route::post('/admin/properties/{id}/toggle-publish', [AdminController::class, 'togglePublish'])->name('admin.properties.toggle-publish');
Route::post('/admin/properties/{id}/toggle-featured', [AdminController::class, 'toggleFeatured'])->name('admin.properties.toggle-featured');

// Admin User Management Routes (Main Admin Only)
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
Route::get('/admin/users/{id}', [AdminController::class, 'getUser'])->name('admin.users.get');
Route::post('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']);
Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
Route::post('/admin/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
