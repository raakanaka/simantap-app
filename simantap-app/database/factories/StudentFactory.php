<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nim' => $this->faker->unique()->numerify('2021###'),
            'password' => Hash::make('password123'),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'study_program' => $this->faker->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknik Komputer',
                'Manajemen Informatika'
            ]),
            'faculty' => 'Fakultas Teknik',
            'semester' => $this->faker->numberBetween(6, 8),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the student is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
