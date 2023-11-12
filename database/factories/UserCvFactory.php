<?php

namespace Database\Factories;

use App\Models\UserCv;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCvFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            UserCv::TITLE => $this->faker->jobTitle(),
            UserCv::ATTACHMENT => $this->faker->randomElement(['uploads/candidate/cv/1697383793.pdf', 'uploads/candidate/cv/1697564798.pdf', 'uploads/candidate/cv/1697582549.pdf']),
            UserCv::IS_DEFAULT => rand(1, 3) === 1 ? 1 : 0
        ];
    }
}
