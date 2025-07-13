<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'password' => Hash::make('123456'),
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
