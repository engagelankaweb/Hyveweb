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

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Panel Action Routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/properties', [AdminController::class, 'storeProperty']);
Route::delete('/admin/properties/{id}', [AdminController::class, 'destroyProperty']);


