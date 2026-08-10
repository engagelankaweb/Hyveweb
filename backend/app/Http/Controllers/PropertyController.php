<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
    public function getPropertiesJs()
    {
        $properties = Property::all();

        // Map database records to the exact structure the frontend expects
        $propertiesArray = $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'title' => $property->title,
                'location' => $property->location,
                'city' => $property->city,
                'type' => $property->type,
                'purpose' => $property->purpose,
                'price' => (float)$property->price,
                'bedrooms' => (int)$property->bedrooms,
                'bathrooms' => (float)$property->bathrooms,
                'area' => (int)$property->area,
                'yearBuilt' => (int)$property->yearBuilt,
                'description' => $property->description,
                'features' => $property->features,
                'images' => $property->images,
                'agent' => $property->agent,
                'featured' => (bool)$property->featured,
            ];
        });

        $jsContent = "const propertiesData = " . json_encode($propertiesArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ";\n";

        return response($jsContent, 200)
            ->header('Content-Type', 'application/javascript');
    }
}
