<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $placement = \App\Models\Placement::inRandomOrder()->first();
        return [
            'placement_id' => $placement->id,
            'institution_id' => $placement->institution_id,
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['hadir', 'absen', 'sakit', 'izin']),
        ];
    }
}
