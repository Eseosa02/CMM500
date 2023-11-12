<?php

namespace Database\Factories;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            JobApplication::MESSAGE => $this->faker->text(random_int(200, 400)),
            JobApplication::STATUS => $this->faker->randomElement(['submitted', 'under-review', 'accepted', 'rejected', 'withdrawn'])
        ];
    }
}
