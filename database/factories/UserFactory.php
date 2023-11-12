<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roleOption = [User::ROLE_EMPLOYER, User::ROLE_CANDIDATE];
        $role = $roleOption[array_rand($roleOption)];
        // $completionPercentage = [60, 90, 100];
        
        if ($role === User::ROLE_EMPLOYER) {
            $name = $this->faker->company();
        } else {
            $name = $this->faker->name();
        }
        
        return [
            User::NAME => $name,
            User::EMAIL => $this->faker->unique()->safeEmail(),
            User::EMAIL_VERIFIED_AT => now(),
            User::PASSWORD => 'Demo123', // Demo123
            User::ROLE => $role,
            // User::IS_COMPLETE => $completionPercentage[array_rand($completionPercentage)],
            User::IS_COMPLETE => 100,
            User::REMEMBER_TOKEN => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                User::EMAIL_VERIFIED_AT => null,
            ];
        });
    }
}
