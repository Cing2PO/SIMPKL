<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlansSeeder::class,
            InstitutionSeeder::class,
            UserSeeder::class,
            PlacementSeeder::class,
            AttendanceSeeder::class,
            EvaluationSeeder::class,
            LogbookSeeder::class,
        ]);
    }
}
