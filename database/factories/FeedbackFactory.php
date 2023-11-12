<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            Feedback::MESSAGE => $this->faker->text(random_int(50, 200)),
            Feedback::RATING => $this->faker->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}
