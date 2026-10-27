<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Main Admin (Executive / Full Access)
        User::updateOrCreate(
            ['email' => 'admin@hyve.com'],
            [
                'name' => 'HYVE Executive Admin',
                'password' => Hash::make('admin123'),
                'role' => 'main_admin',
                'status' => 'active',
                'phone' => '+1 (555) 019-2831',
            ]
        );

        // 2. Listing Agent - Vinuka Maddumage
        User::updateOrCreate(
            ['email' => 'vinuka@hyve.lk'],
            [
                'name' => 'Vinuka Maddumage (Agent)',
                'password' => Hash::make('agent123'),
                'role' => 'agent',
                'status' => 'active',
                'phone' => '+94 77 896 8321',
            ]
        );

        // 3. Listing Agent - Rehan Wijesinghe
        User::updateOrCreate(
            ['email' => 'rehan@hyve.lk'],
            [
                'name' => 'Rehan Wijesinghe (Agent)',
                'password' => Hash::make('agent123'),
                'role' => 'agent',
                'status' => 'active',
                'phone' => '+94 76 190 8254',
            ]
        );

        // Legacy compatibility accounts updated to Vinuka and Rehan
        User::updateOrCreate(
            ['email' => 'staff@hyve.com'],
            [
                'name' => 'Rehan Wijesinghe (Staff)',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
                'status' => 'active',
                'phone' => '+94 76 190 8254',
            ]
        );

        User::updateOrCreate(
            ['email' => 'agent@hyve.com'],
            [
                'name' => 'Vinuka Maddumage (Agent)',
                'password' => Hash::make('agent123'),
                'role' => 'agent',
                'status' => 'active',
                'phone' => '+94 77 896 8321',
            ]
        );
    }
}
