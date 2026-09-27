<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class ShortTermRentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rentals = [
            [
                'title' => 'Oceanfront Luxury Villa',
                'location' => 'South Beach, FL',
                'city' => 'Miami',
                'type' => 'Villa',
                'purpose' => 'rent',
                'rental_type' => 'short_term',
                'price' => 15000,
                'nightly_rate' => 1200,
                'bedrooms' => 5,
                'bathrooms' => 5.5,
                'max_guests' => 10,
                'min_stay' => 3,
                'check_in_time' => '4:00 PM',
                'check_out_time' => '11:00 AM',
                'area' => 4500,
                'yearBuilt' => 2022,
                'description' => 'Experience the ultimate vacation in this stunning oceanfront villa featuring a private infinity pool and direct beach access.',
                'external_booking_url' => 'https://airbnb.com/rooms/111111',
                'features' => ['Infinity Pool', 'Beach Access', 'Smart Home'],
                'images' => [
                    'assets/images/luxury_villa_1786339560928.png',
                    'assets/images/hero_property_1786339547369.png'
                ],
                'agent' => [
                    'name' => 'Sarah Jenkins',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 123-4567'
                ],
                'featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Downtown Skyline Penthouse',
                'location' => 'Tribeca, NY',
                'city' => 'New York',
                'type' => 'Apartment',
                'purpose' => 'rent',
                'rental_type' => 'short_term',
                'price' => 12000,
                'nightly_rate' => 950,
                'bedrooms' => 3,
                'bathrooms' => 3.0,
                'max_guests' => 6,
                'min_stay' => 2,
                'check_in_time' => '3:00 PM',
                'check_out_time' => '12:00 PM',
                'area' => 2800,
                'yearBuilt' => 2018,
                'description' => 'Breathtaking city views from this luxury penthouse. Perfect for executive stays or weekend getaways.',
                'external_booking_url' => 'https://airbnb.com/rooms/222222',
                'features' => ['Skyline Views', 'Private Elevator', 'Rooftop Deck'],
                'images' => [
                    'assets/images/penthouse_interior_1786339582396.png'
                ],
                'agent' => [
                    'name' => 'Michael Chen',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 987-6543'
                ],
                'featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Secluded Mountain Cabin',
                'location' => 'Aspen, CO',
                'city' => 'Aspen',
                'type' => 'House',
                'purpose' => 'rent',
                'rental_type' => 'short_term',
                'price' => 8000,
                'nightly_rate' => 650,
                'bedrooms' => 4,
                'bathrooms' => 3.0,
                'max_guests' => 8,
                'min_stay' => 4,
                'check_in_time' => '4:00 PM',
                'check_out_time' => '10:00 AM',
                'area' => 3200,
                'yearBuilt' => 2015,
                'description' => 'A cozy and luxurious mountain cabin with ski-in/ski-out access and a private hot tub.',
                'external_booking_url' => 'https://vrbo.com/rooms/333333',
                'features' => ['Ski-in/Ski-out', 'Hot Tub', 'Fireplace'],
                'images' => [
                    'assets/images/hero_property_1786339547369.png'
                ],
                'agent' => [
                    'name' => 'Emma Davis',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 333-2222'
                ],
                'featured' => false,
                'is_published' => true,
            ]
        ];

        foreach ($rentals as $rental) {
            Property::create($rental);
        }
    }
}
