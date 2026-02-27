<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Plans::create([
            'name' => 'Trial',
            'price' => 0,
            'duration' => 30,
            'features' => '[]',
        ]);

        \App\Models\Plans::create([
            'name' => 'Basic',
            'price' => 100000,
            'duration' => 30,
            'features' => '[]',
        ]);

        \App\Models\Plans::create([
            'name' => 'Plus',
            'price' => 200000,
            'duration' => 30,
            'features' => '[]',
        ]);

        \App\Models\Plans::create([
            'name' => 'Pro',
            'price' => 300000,
            'duration' => 30,
            'features' => '[]',
        ]);
    }
}
