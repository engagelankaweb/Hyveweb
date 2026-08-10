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
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'yearBuilt',
        'description',
        'features',
        'images',
        'agent',
        'featured',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'agent' => 'array',
        'featured' => 'boolean',
        'price' => 'float',
        'bedrooms' => 'integer',
        'bathrooms' => 'float',
        'area' => 'integer',
        'yearBuilt' => 'integer',
    ];
}
