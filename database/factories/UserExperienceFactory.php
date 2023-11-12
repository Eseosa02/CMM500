<?php

namespace Database\Factories;

use App\Models\UserExperience;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            UserExperience::TITLE => $this->faker->jobTitle(),
            UserExperience::INSTITUTION => $this->faker->company(),
            UserExperience::START_DATE => $this->faker->date(),
            UserExperience::END_DATE => $this->faker->date(),
            UserExperience::DESCRIPTION => Str::substr($this->faker->paragraph(), 0, 254),
        ];
    }
}
