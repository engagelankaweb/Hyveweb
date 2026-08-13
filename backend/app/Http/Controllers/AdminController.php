<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin-login');
    }

    /**
     * Authenticate admin / staff using email & password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        // Check if user exists and is active
        $user = User::where('email', $credentials['email'])->first();
        if ($user && $user->status !== 'active') {
            return back()->with('error', 'This account has been deactivated. Please contact the main administrator.');
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'Invalid email or password. Please try again.');
    }

    /**
     * Logout authenticated user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Update currently authenticated user's profile.
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');

        if ($request->filled('new_password')) {
            if (!$request->filled('current_password') || !Hash::check($request->input('current_password'), $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password does not match.',
                ], 422);
            }
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'user' => $user,
        ]);
    }

    /**
     * Show admin dashboard (properties, short term rentals, user management, metrics).
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $currentUser = Auth::user();
        
        // Fetch properties
        $properties = Property::orderBy('id', 'desc')->get();

        // Short term rentals collection
        $shortTermRentals = Property::where(function($q) {
            $q->where('rental_type', 'short_term')
              ->orWhere(function($sub) {
                  $sub->where('purpose', 'rent')->whereNotNull('nightly_rate');
              });
        })->orderBy('id', 'desc')->get();

        // User list (for main admin)
        $users = $currentUser->isMainAdmin() ? User::orderBy('id', 'asc')->get() : collect();

        // Calculate statistics
        $stats = [
            'total' => $properties->count(),
            'published' => $properties->where('is_published', true)->count(),
            'draft' => $properties->where('is_published', false)->count(),
            'sale' => $properties->where('purpose', 'buy')->count(),
            'rent' => $properties->where('purpose', 'rent')->count(),
            'short_term' => $shortTermRentals->count(),
            'featured' => $properties->where('featured', true)->count(),
            'users_count' => User::count(),
        ];

        return view('admin-dashboard', compact('properties', 'shortTermRentals', 'users', 'currentUser', 'stats'));
    }

    /**
     * Get single property JSON for editing.
     */
    public function getProperty($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $property = Property::find($id);
        if (!$property) {
            return response()->json(['success' => false, 'message' => 'Property not found'], 404);
        }

        return response()->json([
            'success' => true,
            'property' => $property,
        ]);
    }

    /**
     * Store a new property.
     */
    public function storeProperty(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'purpose' => 'required|string|in:buy,rent',
            'rental_type' => 'nullable|string|in:long_term,short_term',
            'price' => 'required|numeric|min:0',
            'nightly_rate' => 'nullable|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'max_guests' => 'nullable|integer|min:0',
            'min_stay' => 'nullable|integer|min:1',
            'check_in_time' => 'nullable|string|max:50',
            'check_out_time' => 'nullable|string|max:50',
            'area' => 'required|integer|min:0',
            'yearBuilt' => 'required|integer|min:1800|max:' . (date('Y') + 5),
            'description' => 'required|string',
            'external_url' => 'nullable|url|max:500',
            'external_booking_url' => 'nullable|url|max:500',
            'features' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'agent_selection' => 'required|string|in:sarah,michael,emma,custom',
            'agent_name' => 'required_if:agent_selection,custom|string|max:255|nullable',
            'agent_phone' => 'required_if:agent_selection,custom|string|max:50|nullable',
            'agent_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Upload images
        $uploadPath = public_path('uploads');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $imagePaths[] = 'uploads/' . $filename;
            }
        }

        if (empty($imagePaths)) {
            $imagePaths = ['assets/images/luxury_villa_1786339560928.png'];
        }

        // Agent details
        $agentDetails = $this->resolveAgentDetails($request, $uploadPath);

        // Features
        $featuresArray = [];
        if ($request->input('features')) {
            $featuresArray = array_values(array_filter(array_map('trim', explode(',', $request->input('features')))));
        }

        // Determine rental type
        $rentalType = $request->input('purpose') === 'rent' ? ($request->input('rental_type') ?: 'long_term') : null;

        $property = new Property();
        $property->title = $request->input('title');
        $property->location = $request->input('location');
        $property->city = $request->input('city');
        $property->type = $request->input('type');
        $property->purpose = $request->input('purpose');
        $property->rental_type = $rentalType;
        $property->price = (float)$request->input('price');
        $property->nightly_rate = $request->filled('nightly_rate') ? (float)$request->input('nightly_rate') : null;
        $property->bedrooms = (int)$request->input('bedrooms');
        $property->bathrooms = (float)$request->input('bathrooms');
        $property->max_guests = $request->filled('max_guests') ? (int)$request->input('max_guests') : null;
        $property->min_stay = $request->filled('min_stay') ? (int)$request->input('min_stay') : null;
        $property->check_in_time = $request->input('check_in_time');
        $property->check_out_time = $request->input('check_out_time');
        $property->area = (int)$request->input('area');
        $property->yearBuilt = (int)$request->input('yearBuilt');
        $property->description = $request->input('description');
        $property->external_url = $request->input('external_url');
        $property->external_booking_url = $request->input('external_booking_url');
        $property->features = $featuresArray;
        $property->images = $imagePaths;
        $property->agent = $agentDetails;
        $property->featured = $request->has('featured');
        $property->is_published = $request->has('is_published') ? (bool)$request->input('is_published') : true;
        $property->save();

        return response()->json([
            'success' => true,
            'message' => 'Property listing created successfully!',
            'property' => $property,
        ]);
    }

    /**
     * Update an existing property.
     */
    public function updateProperty(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $property = Property::find($id);
        if (!$property) {
            return response()->json(['success' => false, 'message' => 'Property not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'purpose' => 'required|string|in:buy,rent',
            'rental_type' => 'nullable|string|in:long_term,short_term',
            'price' => 'required|numeric|min:0',
            'nightly_rate' => 'nullable|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'max_guests' => 'nullable|integer|min:0',
            'min_stay' => 'nullable|integer|min:1',
            'check_in_time' => 'nullable|string|max:50',
            'check_out_time' => 'nullable|string|max:50',
            'area' => 'required|integer|min:0',
            'yearBuilt' => 'required|integer|min:1800|max:' . (date('Y') + 5),
            'description' => 'required|string',
            'external_url' => 'nullable|url|max:500',
            'external_booking_url' => 'nullable|url|max:500',
            'features' => 'nullable|string',
            'existing_images' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'agent_selection' => 'required|string|in:sarah,michael,emma,custom,keep',
            'agent_name' => 'required_if:agent_selection,custom|string|max:255|nullable',
            'agent_phone' => 'required_if:agent_selection,custom|string|max:50|nullable',
            'agent_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $uploadPath = public_path('uploads');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Handle existing images retained
        $retainedImages = $request->input('existing_images', []);
        if (!is_array($retainedImages)) {
            $retainedImages = json_decode($retainedImages, true) ?: [];
        }

        // Upload any newly added images
        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $newImages[] = 'uploads/' . $filename;
            }
        }

        $allImages = array_values(array_unique(array_merge($retainedImages, $newImages)));
        if (empty($allImages)) {
            $allImages = is_array($property->images) && count($property->images) > 0 ? $property->images : ['assets/images/luxury_villa_1786339560928.png'];
        }

        // Agent details
        if ($request->input('agent_selection') === 'keep') {
            $agentDetails = $property->agent;
        } else {
            $agentDetails = $this->resolveAgentDetails($request, $uploadPath);
        }

        // Features
        $featuresArray = [];
        if ($request->input('features')) {
            $featuresArray = array_values(array_filter(array_map('trim', explode(',', $request->input('features')))));
        }

        $rentalType = $request->input('purpose') === 'rent' ? ($request->input('rental_type') ?: 'long_term') : null;

        $property->title = $request->input('title');
        $property->location = $request->input('location');
        $property->city = $request->input('city');
        $property->type = $request->input('type');
        $property->purpose = $request->input('purpose');
        $property->rental_type = $rentalType;
        $property->price = (float)$request->input('price');
        $property->nightly_rate = $request->filled('nightly_rate') ? (float)$request->input('nightly_rate') : null;
        $property->bedrooms = (int)$request->input('bedrooms');
        $property->bathrooms = (float)$request->input('bathrooms');
        $property->max_guests = $request->filled('max_guests') ? (int)$request->input('max_guests') : null;
        $property->min_stay = $request->filled('min_stay') ? (int)$request->input('min_stay') : null;
        $property->check_in_time = $request->input('check_in_time');
        $property->check_out_time = $request->input('check_out_time');
        $property->area = (int)$request->input('area');
        $property->yearBuilt = (int)$request->input('yearBuilt');
        $property->description = $request->input('description');
        $property->external_url = $request->input('external_url');
        $property->external_booking_url = $request->input('external_booking_url');
        $property->features = $featuresArray;
        $property->images = $allImages;
        $property->agent = $agentDetails;
        $property->featured = $request->has('featured');
        $property->is_published = $request->has('is_published') ? (bool)$request->input('is_published') : $property->is_published;
        $property->save();

        return response()->json([
            'success' => true,
            'message' => 'Property listing updated successfully!',
            'property' => $property,
        ]);
    }

    /**
     * Toggle Publish status of a property.
     */
    public function togglePublish($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $property = Property::find($id);
        if (!$property) {
            return response()->json(['success' => false, 'message' => 'Property not found'], 404);
        }

        $property->is_published = !$property->is_published;
        $property->save();

        return response()->json([
            'success' => true,
            'is_published' => $property->is_published,
            'message' => $property->is_published ? 'Listing published to catalog.' : 'Listing set to draft (hidden from catalog).',
        ]);
    }

    /**
     * Toggle Featured status of a property.
     */
    public function toggleFeatured($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $property = Property::find($id);
        if (!$property) {
            return response()->json(['success' => false, 'message' => 'Property not found'], 404);
        }

        $property->featured = !$property->featured;
        $property->save();

        return response()->json([
            'success' => true,
            'featured' => $property->featured,
            'message' => $property->featured ? 'Listing marked as Featured.' : 'Listing unmarked from Featured.',
        ]);
    }

    /**
     * Delete a property.
     */
    public function destroyProperty($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $property = Property::find($id);
        if (!$property) {
            return response()->json([
                'success' => false,
                'message' => 'Property not found.',
            ], 404);
        }

        // Clean up uploaded images
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

        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully!',
        ]);
    }

    // ==========================================
    // USER MANAGEMENT METHODS (MAIN ADMIN ONLY)
    // ==========================================

    /**
     * Store a new administrator or staff user.
     */
    public function storeUser(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isMainAdmin()) {
            return response()->json(['message' => 'Unauthorized. Main Administrator role required.'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:main_admin,staff,agent',
            'phone' => 'nullable|string|max:50',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->status = $request->input('status', 'active');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "User {$user->name} created successfully!",
            'user' => $user,
        ]);
    }

    /**
     * Get user details for edit.
     */
    public function getUser($id)
    {
        if (!Auth::check() || !Auth::user()->isMainAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    /**
     * Update an administrator / staff user.
     */
    public function updateUser(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isMainAdmin()) {
            return response()->json(['message' => 'Unauthorized. Main Administrator role required.'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:main_admin,staff,agent',
            'phone' => 'nullable|string|max:50',
            'status' => 'required|string|in:active,inactive',
            'password' => 'nullable|string|min:6',
        ]);

        // Safety: Prevent removing the only active main_admin
        if ($user->role === 'main_admin' && ($request->input('role') !== 'main_admin' || $request->input('status') !== 'active')) {
            $otherMainAdmins = User::where('role', 'main_admin')->where('status', 'active')->where('id', '!=', $id)->count();
            if ($otherMainAdmins === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot demote or deactivate the last active Main Administrator.',
                ], 422);
            }
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->status = $request->input('status');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => "User {$user->name} updated successfully!",
            'user' => $user,
        ]);
    }

    /**
     * Toggle active/inactive status of a user.
     */
    public function toggleUserStatus($id)
    {
        if (!Auth::check() || !Auth::user()->isMainAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (Auth::id() == $id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot deactivate your own account.',
            ], 422);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';

        // Check if last active main admin
        if ($user->role === 'main_admin' && $newStatus === 'inactive') {
            $otherMainAdmins = User::where('role', 'main_admin')->where('status', 'active')->where('id', '!=', $id)->count();
            if ($otherMainAdmins === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot deactivate the last active Main Administrator.',
                ], 422);
            }
        }

        $user->status = $newStatus;
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status,
            'message' => "User {$user->name} is now {$user->status}.",
        ]);
    }

    /**
     * Delete a user account.
     */
    public function destroyUser($id)
    {
        if (!Auth::check() || !Auth::user()->isMainAdmin()) {
            return response()->json(['message' => 'Unauthorized. Main Administrator role required.'], 403);
        }

        if (Auth::id() == $id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        // Prevent deleting last main admin
        if ($user->role === 'main_admin') {
            $otherMainAdmins = User::where('role', 'main_admin')->where('id', '!=', $id)->count();
            if ($otherMainAdmins === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete the last Main Administrator account.',
                ], 422);
            }
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!',
        ]);
    }

    /**
     * Helper to resolve agent details array.
     */
    private function resolveAgentDetails(Request $request, string $uploadPath): array
    {
        $selection = $request->input('agent_selection');

        if ($selection === 'sarah') {
            return [
                'name' => 'Sarah Jenkins',
                'image' => 'assets/images/agent_office_1786339595128.png',
                'phone' => '+1 (555) 123-4567'
            ];
        } elseif ($selection === 'michael') {
            return [
                'name' => 'Michael Chen',
                'image' => 'assets/images/agent_office_1786339595128.png',
                'phone' => '+1 (555) 987-6543'
            ];
        } elseif ($selection === 'emma') {
            return [
                'name' => 'Emma Davis',
                'image' => 'assets/images/agent_office_1786339595128.png',
                'phone' => '+1 (555) 333-2222'
            ];
        } else {
            // Custom agent
            $agentImageName = 'assets/images/agent_office_1786339595128.png';
            if ($request->hasFile('agent_image')) {
                $file = $request->file('agent_image');
                $filename = 'agent_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $agentImageName = 'uploads/' . $filename;
            }

            return [
                'name' => $request->input('agent_name'),
                'phone' => $request->input('agent_phone'),
                'image' => $agentImageName
            ];
        }
    }
}
