<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'city',
        'type',
        'purpose',
        'rental_type',
        'price',
        'nightly_rate',
        'bedrooms',
        'bathrooms',
        'max_guests',
        'min_stay',
        'check_in_time',
        'check_out_time',
        'area',
        'yearBuilt',
        'description',
        'external_url',
        'external_booking_url',
        'features',
        'images',
        'agent',
        'featured',
        'is_published',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'agent' => 'array',
        'featured' => 'boolean',
        'is_published' => 'boolean',
        'price' => 'float',
        'nightly_rate' => 'float',
        'bedrooms' => 'integer',
        'bathrooms' => 'float',
        'max_guests' => 'integer',
        'min_stay' => 'integer',
        'area' => 'integer',
        'yearBuilt' => 'integer',
    ];
}
