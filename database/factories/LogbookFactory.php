<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\logbook>
 */
class LogbookFactory extends Factory
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
            'date' => $this->faker->date(),
            'activity' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];
    }

}
