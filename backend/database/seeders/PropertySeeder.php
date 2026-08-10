<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            [
                'id' => 1,
                'title' => 'Modern Luxury Villa',
                'location' => 'Beverly Hills, CA',
                'city' => 'Los Angeles',
                'type' => 'Villa',
                'purpose' => 'buy',
                'price' => 8500000,
                'bedrooms' => 5,
                'bathrooms' => 6.0,
                'area' => 7500,
                'yearBuilt' => 2022,
                'description' => 'A stunning, ultra-luxurious modern architectural home with large glass windows, an infinity pool, and panoramic views of the city. Featuring a state-of-the-art kitchen, smart home technology, and a private cinema.',
                'features' => json_encode(['Infinity Pool', 'Smart Home', 'Home Theater', 'Wine Cellar', '3-Car Garage']),
                'images' => json_encode([
                    'assets/images/hero_property_1786339547369.png',
                    'assets/images/luxury_villa_1786339560928.png',
                    'assets/images/penthouse_interior_1786339582396.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Sarah Jenkins',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 123-4567'
                ]),
                'featured' => true,
            ],
            [
                'id' => 2,
                'title' => 'Downtown Penthouse',
                'location' => 'Manhattan, NY',
                'city' => 'New York',
                'type' => 'Apartment',
                'purpose' => 'buy',
                'price' => 12400000,
                'bedrooms' => 4,
                'bathrooms' => 4.5,
                'area' => 4200,
                'yearBuilt' => 2018,
                'description' => 'Spectacular penthouse in the heart of Manhattan featuring floor-to-ceiling windows, a private rooftop terrace, and exquisite modern finishes.',
                'features' => json_encode(['Rooftop Terrace', 'Doorman', 'Fitness Center', 'City Views']),
                'images' => json_encode([
                    'assets/images/penthouse_interior_1786339582396.png',
                    'assets/images/hero_property_1786339547369.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Michael Chen',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 987-6543'
                ]),
                'featured' => true,
            ],
            [
                'id' => 3,
                'title' => 'Ocean View Estate',
                'location' => 'Malibu, CA',
                'city' => 'Los Angeles',
                'type' => 'House',
                'purpose' => 'buy',
                'price' => 15500000,
                'bedrooms' => 6,
                'bathrooms' => 7.0,
                'area' => 9000,
                'yearBuilt' => 2020,
                'description' => 'Private beachfront estate with direct access to the ocean. Incredible outdoor living spaces, guest house, and custom imported materials throughout.',
                'features' => json_encode(['Beach Access', 'Guest House', 'Outdoor Kitchen', 'Spa']),
                'images' => json_encode([
                    'assets/images/luxury_villa_1786339560928.png',
                    'assets/images/hero_property_1786339547369.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Sarah Jenkins',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 123-4567'
                ]),
                'featured' => true,
            ],
            [
                'id' => 4,
                'title' => 'Contemporary Family Home',
                'location' => 'Austin, TX',
                'city' => 'Austin',
                'type' => 'House',
                'purpose' => 'buy',
                'price' => 2100000,
                'bedrooms' => 4,
                'bathrooms' => 3.0,
                'area' => 3200,
                'yearBuilt' => 2019,
                'description' => 'Beautiful modern family home in a highly sought-after neighborhood. Open floor plan, large backyard, and excellent school district.',
                'features' => json_encode(['Large Backyard', 'Open Plan', 'Gourmet Kitchen']),
                'images' => json_encode([
                    'assets/images/hero_property_1786339547369.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Emma Davis',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 333-2222'
                ]),
                'featured' => false,
            ],
            [
                'id' => 5,
                'title' => 'Luxury City Residence',
                'location' => 'River North, Chicago',
                'city' => 'Chicago',
                'type' => 'Condo',
                'purpose' => 'buy',
                'price' => 1850000,
                'bedrooms' => 3,
                'bathrooms' => 2.5,
                'area' => 2400,
                'yearBuilt' => 2015,
                'description' => 'Elegant condo offering stunning river and city views. Full-service building with top-tier amenities.',
                'features' => json_encode(['Concierge', 'Pool', 'Gym', 'Balcony']),
                'images' => json_encode([
                    'assets/images/penthouse_interior_1786339582396.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Michael Chen',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 987-6543'
                ]),
                'featured' => true,
            ],
            [
                'id' => 6,
                'title' => 'Private Garden Villa',
                'location' => 'Coral Gables, FL',
                'city' => 'Miami',
                'type' => 'Villa',
                'purpose' => 'buy',
                'price' => 5200000,
                'bedrooms' => 5,
                'bathrooms' => 5.0,
                'area' => 5100,
                'yearBuilt' => 2008,
                'description' => 'Mediterranean-style villa surrounded by lush tropical landscaping. Features a resort-style pool and elegant interior finishes.',
                'features' => json_encode(['Tropical Garden', 'Resort Pool', 'Outdoor Dining']),
                'images' => json_encode([
                    'assets/images/luxury_villa_1786339560928.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Emma Davis',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 333-2222'
                ]),
                'featured' => true,
            ],
            [
                'id' => 7,
                'title' => 'Sleek Urban Loft',
                'location' => 'SoHo, NY',
                'city' => 'New York',
                'type' => 'Apartment',
                'purpose' => 'rent',
                'price' => 8500,
                'bedrooms' => 2,
                'bathrooms' => 2.0,
                'area' => 1800,
                'yearBuilt' => 1920,
                'description' => 'Authentic SoHo loft with exposed brick, massive windows, and high ceilings. Completely renovated with high-end appliances.',
                'features' => json_encode(['Exposed Brick', 'High Ceilings', 'In-unit Washer/Dryer']),
                'images' => json_encode([
                    'assets/images/penthouse_interior_1786339582396.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Michael Chen',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 987-6543'
                ]),
                'featured' => false,
            ],
            [
                'id' => 8,
                'title' => 'Executive Office Space',
                'location' => 'Financial District, SF',
                'city' => 'San Francisco',
                'type' => 'Commercial',
                'purpose' => 'rent',
                'price' => 15000,
                'bedrooms' => 0,
                'bathrooms' => 4.0,
                'area' => 5000,
                'yearBuilt' => 2010,
                'description' => 'Premium office space in a Class A building. Features private offices, a large conference room, and break area with views of the bay.',
                'features' => json_encode(['Class A Building', 'Bay Views', 'Conference Room', '24/7 Access']),
                'images' => json_encode([
                    'assets/images/agent_office_1786339595128.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Sarah Jenkins',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 123-4567'
                ]),
                'featured' => false,
            ],
            [
                'id' => 9,
                'title' => 'Suburban Retreat',
                'location' => 'Bellevue, WA',
                'city' => 'Seattle',
                'type' => 'House',
                'purpose' => 'buy',
                'price' => 2800000,
                'bedrooms' => 4,
                'bathrooms' => 3.5,
                'area' => 3800,
                'yearBuilt' => 2016,
                'description' => 'Peaceful home nestled in nature with easy access to the city. Features a custom kitchen and a large deck for entertaining.',
                'features' => json_encode(['Wooded Lot', 'Large Deck', 'Custom Kitchen']),
                'images' => json_encode([
                    'assets/images/hero_property_1786339547369.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Emma Davis',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 333-2222'
                ]),
                'featured' => false,
            ],
            [
                'id' => 10,
                'title' => 'Boutique Retail Space',
                'location' => 'Melrose Ave, LA',
                'city' => 'Los Angeles',
                'type' => 'Commercial',
                'purpose' => 'rent',
                'price' => 12000,
                'bedrooms' => 0,
                'bathrooms' => 1.0,
                'area' => 1200,
                'yearBuilt' => 1985,
                'description' => 'High foot-traffic retail location perfect for a boutique or cafe. Excellent street visibility.',
                'features' => json_encode(['Street Frontage', 'High Visibility', 'Renovated Interior']),
                'images' => json_encode([
                    'assets/images/luxury_villa_1786339560928.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Sarah Jenkins',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 123-4567'
                ]),
                'featured' => false,
            ],
            [
                'id' => 11,
                'title' => 'Mountain View Estate',
                'location' => 'Aspen, CO',
                'city' => 'Aspen',
                'type' => 'Villa',
                'purpose' => 'buy',
                'price' => 18500000,
                'bedrooms' => 6,
                'bathrooms' => 8.0,
                'area' => 11000,
                'yearBuilt' => 2021,
                'description' => 'Ski-in/ski-out luxury estate with breathtaking mountain views. Includes an indoor pool, spa, and massive stone fireplaces.',
                'features' => json_encode(['Ski-in/Ski-out', 'Indoor Pool', 'Home Spa', 'Wine Room']),
                'images' => json_encode([
                    'assets/images/hero_property_1786339547369.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Michael Chen',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 987-6543'
                ]),
                'featured' => true,
            ],
            [
                'id' => 12,
                'title' => 'Modern Minimalist Condo',
                'location' => 'Downtown, Miami',
                'city' => 'Miami',
                'type' => 'Condo',
                'purpose' => 'rent',
                'price' => 5500,
                'bedrooms' => 2,
                'bathrooms' => 2.0,
                'area' => 1400,
                'yearBuilt' => 2019,
                'description' => 'Sleek and modern condo in the heart of downtown. Wraparound balcony and floor-to-ceiling glass.',
                'features' => json_encode(['Wraparound Balcony', 'Smart Tech', 'Building Gym']),
                'images' => json_encode([
                    'assets/images/penthouse_interior_1786339582396.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Emma Davis',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 333-2222'
                ]),
                'featured' => false,
            ],
            [
                'id' => 13,
                'title' => 'Historic Townhouse',
                'location' => 'Beacon Hill, MA',
                'city' => 'Boston',
                'type' => 'House',
                'purpose' => 'buy',
                'price' => 4100000,
                'bedrooms' => 4,
                'bathrooms' => 3.5,
                'area' => 3100,
                'yearBuilt' => 1890,
                'description' => 'Beautifully preserved historic townhouse with modern updates. Features original crown molding, fireplaces, and a private courtyard.',
                'features' => json_encode(['Historic Details', 'Private Courtyard', 'Fireplaces']),
                'images' => json_encode([
                    'assets/images/luxury_villa_1786339560928.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Sarah Jenkins',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 123-4567'
                ]),
                'featured' => false,
            ],
            [
                'id' => 14,
                'title' => 'Seaside Apartment',
                'location' => 'Santa Monica, CA',
                'city' => 'Los Angeles',
                'type' => 'Apartment',
                'purpose' => 'rent',
                'price' => 7200,
                'bedrooms' => 2,
                'bathrooms' => 2.0,
                'area' => 1600,
                'yearBuilt' => 2014,
                'description' => 'Steps from the beach, this bright apartment offers ocean breezes and sunset views from a private balcony.',
                'features' => json_encode(['Ocean View', 'Balcony', 'Gated Parking']),
                'images' => json_encode([
                    'assets/images/penthouse_interior_1786339582396.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Michael Chen',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 987-6543'
                ]),
                'featured' => false,
            ],
            [
                'id' => 15,
                'title' => 'Sprawling Ranch',
                'location' => 'Scottsdale, AZ',
                'city' => 'Phoenix',
                'type' => 'House',
                'purpose' => 'buy',
                'price' => 3500000,
                'bedrooms' => 5,
                'bathrooms' => 4.0,
                'area' => 6000,
                'yearBuilt' => 2005,
                'description' => 'Single-story ranch home on 2 acres of land. Features a massive outdoor entertaining area with pool and desert views.',
                'features' => json_encode(['2 Acres', 'Pool', 'Outdoor Kitchen', 'Guest Casita']),
                'images' => json_encode([
                    'assets/images/luxury_villa_1786339560928.png'
                ]),
                'agent' => json_encode([
                    'name' => 'Emma Davis',
                    'image' => 'assets/images/agent_office_1786339595128.png',
                    'phone' => '+1 (555) 333-2222'
                ]),
                'featured' => false,
            ],
        ];

        foreach ($properties as $property) {
            Property::create([
                'id' => $property['id'],
                'title' => $property['title'],
                'location' => $property['location'],
                'city' => $property['city'],
                'type' => $property['type'],
                'purpose' => $property['purpose'],
                'price' => $property['price'],
                'bedrooms' => $property['bedrooms'],
                'bathrooms' => $property['bathrooms'],
                'area' => $property['area'],
                'yearBuilt' => $property['yearBuilt'],
                'description' => $property['description'],
                'features' => json_decode($property['features'], true),
                'images' => json_decode($property['images'], true),
                'agent' => json_decode($property['agent'], true),
                'featured' => $property['featured'],
            ]);
        }
    }
}
