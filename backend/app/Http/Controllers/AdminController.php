<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin(Request $request)
    {
        if ($request->session()->get('is_admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin-login');
    }

    /**
     * Authenticate admin using password.
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->input('password') === 'hyvead789') {
            $request->session()->put('is_admin', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid password. Please try again.');
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        return redirect()->route('admin.login');
    }

    /**
     * Show admin dashboard (properties list and add form).
     */
    public function index()
    {
        if (!session()->get('is_admin')) {
            return redirect()->route('admin.login');
        }
        $properties = Property::orderBy('id', 'desc')->get();
        return view('admin-dashboard', compact('properties'));
    }

    /**
     * Store a new property.
     */
    public function storeProperty(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'purpose' => 'required|string|in:buy,rent',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'area' => 'required|integer|min:0',
            'yearBuilt' => 'required|integer|min:1800|max:' . (date('Y') + 5),
            'description' => 'required|string',
            'features' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'agent_selection' => 'required|string|in:sarah,michael,emma,custom',
            'agent_name' => 'required_if:agent_selection,custom|string|max:255|nullable',
            'agent_phone' => 'required_if:agent_selection,custom|string|max:50|nullable',
            'agent_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Create uploads directory if it doesn't exist
        $uploadPath = public_path('uploads');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Upload images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $imagePaths[] = 'uploads/' . $filename;
            }
        }

        // Fallback placeholder image if none uploaded
        if (empty($imagePaths)) {
            $imagePaths = ['assets/images/luxury_villa_1786339560928.png'];
        }

        // Determine agent details
        $agentDetails = [];
        $selection = $request->input('agent_selection');

        if ($selection === 'sarah') {
            $agentDetails = [
                'name' => 'Sarah Jenkins',
                'image' => 'assets/images/agent_office_1786339595128.png',
                'phone' => '+1 (555) 123-4567'
            ];
        } elseif ($selection === 'michael') {
            $agentDetails = [
                'name' => 'Michael Chen',
                'image' => 'assets/images/agent_office_1786339595128.png',
                'phone' => '+1 (555) 987-6543'
            ];
        } elseif ($selection === 'emma') {
            $agentDetails = [
                'name' => 'Emma Davis',
                'image' => 'assets/images/agent_office_1786339595128.png',
                'phone' => '+1 (555) 333-2222'
            ];
        } else {
            // Custom agent
            $agentImageName = 'assets/images/agent_office_1786339595128.png'; // fallback
            if ($request->hasFile('agent_image')) {
                $file = $request->file('agent_image');
                $filename = 'agent_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $agentImageName = 'uploads/' . $filename;
            }

            $agentDetails = [
                'name' => $request->input('agent_name'),
                'phone' => $request->input('agent_phone'),
                'image' => $agentImageName
            ];
        }

        // Process features (comma separated)
        $featuresArray = [];
        if ($request->input('features')) {
            $featuresArray = array_filter(array_map('trim', explode(',', $request->input('features'))));
        }

        // Create the property
        $property = new Property();
        $property->title = $request->input('title');
        $property->location = $request->input('location');
        $property->city = $request->input('city');
        $property->type = $request->input('type');
        $property->purpose = $request->input('purpose');
        $property->price = (float)$request->input('price');
        $property->bedrooms = (int)$request->input('bedrooms');
        $property->bathrooms = (float)$request->input('bathrooms');
        $property->area = (int)$request->input('area');
        $property->yearBuilt = (int)$request->input('yearBuilt');
        $property->description = $request->input('description');
        $property->features = $featuresArray;
        $property->images = $imagePaths;
        $property->agent = $agentDetails;
        $property->featured = $request->has('featured');
        $property->save();

        return response()->json([
            'success' => true,
            'message' => 'Property added successfully!'
        ]);
    }

    /**
     * Delete a property.
     */
    public function destroyProperty($id)
    {
        if (!session()->get('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $property = Property::find($id);

        if (!$property) {
            return response()->json([
                'success' => false,
                'message' => 'Property not found.'
            ], 404);
        }

        // Optional: Clean up images associated with this property if they are in the uploads folder
        if (is_array($property->images)) {
            foreach ($property->images as $path) {
                if (str_starts_with($path, 'uploads/')) {
                    $fullPath = public_path($path);
                    if (File::exists($fullPath)) {
                        File::delete($fullPath);
                    }
                }
            }
        }

        // Optional: Clean up custom agent image if it's in uploads
        if (isset($property->agent['image']) && str_starts_with($property->agent['image'], 'uploads/')) {
            $fullPath = public_path($property->agent['image']);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully!'
        ]);
    }
}
