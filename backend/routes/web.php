<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return file_get_contents(public_path('index.html'));
});

Route::get('/js/properties.js', [PropertyController::class, 'getPropertiesJs']);
