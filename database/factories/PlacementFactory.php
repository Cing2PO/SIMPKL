<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\placement>
 */
class PlacementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $institutionId = \App\Models\Institution::inRandomOrder()->first()?->id;
        $studentId = \App\Models\User::where('role', 'murid')->where('institution_id', $institutionId)->inRandomOrder()->first()?->id;
        $mentorId = \App\Models\User::where('role', 'guru')->where('institution_id', $institutionId)->inRandomOrder()->first()?->id;
        return [
            'student_id' => $studentId,
            'institution_id' => $institutionId,
            'mentor_id' => $mentorId,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
