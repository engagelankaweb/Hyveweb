<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return file_get_contents(base_path('../index.html'));
});

// Whitelisted static pages — prevents path traversal to backup/diff/internal files
Route::get('/{page}.html', function ($page) {
    $allowed = ['index', 'about', 'agents', 'contact', 'properties', 'property-details', 'services', 'short-term-rentals'];
    if (!in_array($page, $allowed, true)) {
        abort(404);
    }
    $path = base_path('../' . $page . '.html');
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    abort(404);
});

// Public API endpoints
Route::get('/api/properties-data.js', [PropertyController::class, 'getPropertiesJs']);
// Throttle: max 5 form submissions per minute to prevent email spam
Route::post('/api/list-property', [PropertyController::class, 'listProperty'])->middleware('throttle:5,1');

// Admin Login & Logout (accessible when unauthenticated)
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
// Throttle: max 5 login attempts per minute to prevent brute-force
Route::post('/admin/login', [AdminController::class, 'login'])->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// All admin management routes require authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard & Profile
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // Property Management
    Route::get('/admin/properties/{id}', [AdminController::class, 'getProperty'])->name('admin.properties.get');
    Route::post('/admin/properties', [AdminController::class, 'storeProperty'])->name('admin.properties.store');
    Route::post('/admin/properties/{id}', [AdminController::class, 'updateProperty'])->name('admin.properties.update');
    Route::put('/admin/properties/{id}', [AdminController::class, 'updateProperty']);
    Route::delete('/admin/properties/{id}', [AdminController::class, 'destroyProperty'])->name('admin.properties.destroy');
    Route::post('/admin/properties/{id}/toggle-publish', [AdminController::class, 'togglePublish'])->name('admin.properties.toggle-publish');
    Route::post('/admin/properties/{id}/toggle-featured', [AdminController::class, 'toggleFeatured'])->name('admin.properties.toggle-featured');

    // User Management (main admin only — enforced additionally in controller)
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{id}', [AdminController::class, 'getUser'])->name('admin.users.get');
    Route::post('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::post('/admin/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
});
