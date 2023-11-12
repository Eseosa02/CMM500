<?php

namespace Database\Factories;

use App\Models\UserEducation;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserEducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            UserEducation::TITLE => $this->faker->jobTitle(),
            UserEducation::INSTITUTION => $this->faker->company(),
            UserEducation::START_DATE => $this->faker->date(),
            UserEducation::END_DATE => $this->faker->date(),
            UserEducation::GRADE => $this->faker->randomElement(['merit', 'distinct', 'pass']),
        ];
    }
}
