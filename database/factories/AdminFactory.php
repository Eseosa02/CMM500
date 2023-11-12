<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            Admin::NAME => $this->faker->name(),
            Admin::EMAIL => $this->faker->unique()->safeEmail(),
            Admin::PASSWORD => 'Demo123', // Demo123
            Admin::PHONE => $this->faker->phoneNumber(),
            Admin::STATUS => $this->faker->randomElement(['active', 'disabled'])
        ];
    }
}
