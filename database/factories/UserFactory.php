<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'institution_id' => \App\Models\Institution::inRandomOrder()->first()?->id,
            'role' => $this->faker->randomElement(['student', 'mentor', 'admin']),
        ];
    }

    /**
     * State for superadmin user (no institution).
     */
    public function superadmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'superadmin',
            'institution_id' => null,
        ]);
    }

    /**
     * State for admin user.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * State for mentor/teacher user.
     */
    public function guru(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'guru',
        ]);
    }

    /**
     * State for student user.
     */
    public function murid(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'murid',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
