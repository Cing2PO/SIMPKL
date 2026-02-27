<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institution>
 */
class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $planId = \App\Models\Plans::inRandomOrder()->first()?->id;
        if ($planId == 1) {
            $status = 'trial';
        } else {
            $status = $this->faker->randomElement(['active', 'canceled', 'expired']);
        }
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'contact_phone' => $this->faker->phoneNumber(),
            'plan_id' => $planId,
            'status' => $status,
        ];
    }
}
