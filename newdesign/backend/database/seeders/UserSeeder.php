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

        // 2. Staff / Operations Manager
        User::updateOrCreate(
            ['email' => 'staff@hyve.com'],
            [
                'name' => 'Sarah Jenkins (Staff)',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
                'status' => 'active',
                'phone' => '+1 (555) 123-4567',
            ]
        );

        // 3. Listing Agent
        User::updateOrCreate(
            ['email' => 'agent@hyve.com'],
            [
                'name' => 'Michael Chen (Agent)',
                'password' => Hash::make('agent123'),
                'role' => 'agent',
                'status' => 'active',
                'phone' => '+1 (555) 987-6543',
            ]
        );
    }
}
