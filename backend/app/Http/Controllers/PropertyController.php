<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ListPropertyMail;

class PropertyController extends Controller
{
    public function listProperty(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'property_type' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'additional_notes' => 'nullable|string',
        ]);

        Mail::to('info@hyve.lk')->send(new ListPropertyMail($validated));

        return response()->json(['message' => 'Property listed successfully!']);
    }
    public function getPropertiesJs()
    {
        // Only return published properties for the public website
        $properties = Property::where('is_published', true)->orderBy('id', 'desc')->get();

        // Map database records to the exact structure the frontend expects
        $propertiesArray = $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'title' => $property->title,
                'location' => $property->location,
                'city' => $property->city,
                'type' => $property->type,
                'purpose' => $property->purpose,
                'rental_type' => $property->rental_type,
                'price' => (float)$property->price,
                'nightly_rate' => $property->nightly_rate ? (float)$property->nightly_rate : null,
                'bedrooms' => (int)$property->bedrooms,
                'bathrooms' => (float)$property->bathrooms,
                'max_guests' => $property->max_guests ? (int)$property->max_guests : null,
                'min_stay' => $property->min_stay ? (int)$property->min_stay : null,
                'check_in_time' => $property->check_in_time,
                'check_out_time' => $property->check_out_time,
                'area' => (int)$property->area,
                'yearBuilt' => (int)$property->yearBuilt,
                'description' => $property->description,
                'external_url' => $property->external_url,
                'external_booking_url' => $property->external_booking_url,
                'features' => $property->features ?: [],
                'images' => $property->images ?: [],
                'agent' => $property->agent ?: [],
                'featured' => (bool)$property->featured,
                'is_published' => (bool)$property->is_published,
            ];
        });

        $jsContent = "const propertiesData = " . json_encode($propertiesArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ";\n";

        return response($jsContent, 200)
            ->header('Content-Type', 'application/javascript');
    }
}
