<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1 superadmin manually
        \App\Models\User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'superadmin',
            'institution_id' => null,
        ]);

        // Get all institutions
        $institutions = \App\Models\Institution::all();

        foreach ($institutions as $institution) {
            // Create 1 admin per institution
            \App\Models\User::factory()
                ->admin()
                ->for($institution, 'institution')
                ->create([
                    'name' => 'Admin ' . $institution->name,
                    'email' => 'admin.' . strtolower(str_replace(' ', '.', $institution->name)) . '@simpkl.local',
                ]);

            // Create 2 mentors per institution
            \App\Models\User::factory()
                ->count(2)
                ->guru()
                ->for($institution, 'institution')
                ->create();

            // Create 5 students per institution
            \App\Models\User::factory()
                ->count(5)
                ->murid()
                ->for($institution, 'institution')
                ->create();
        }
    }
}
