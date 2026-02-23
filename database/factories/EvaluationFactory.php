<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'placement_id' => \App\Models\Placement::inRandomOrder()->first()?->id,
            'final_score' => $this->faker->numberBetween(1, 100),
            'feedback' => $this->faker->paragraph(),
        ];
    }
}
