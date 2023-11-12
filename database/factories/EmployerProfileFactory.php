<?php

namespace Database\Factories;

use App\Models\EmployerProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class EmployerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $industryOption = [array('Banking', 'Digital&Creative', 'Human Resources'), array('Management', 'Retail')];
        $industry = $industryOption[array_rand($industryOption)];
        $description = implode('<br><br>', [$this->faker->text(random_int(500, 800)), $this->faker->text(random_int(500, 800)), $this->faker->text(random_int(500, 800))]);
        $country = (new Controller)->getCountries()[array_rand((new Controller)->getCountries())];
        
        return [
            EmployerProfile::UNIQUE_ID => Str::random(25),
            EmployerProfile::DESCRIPTION => $description,
            EmployerProfile::PHONE => $this->faker->phoneNumber(),
            EmployerProfile::INDUSTRY => $industry,
            EmployerProfile::COMPANY_SIZE => $this->faker->randomElement(['50 - 100', '100 - 150', '200 - 250', '300 - 350', '500 - 1000']),
            EmployerProfile::FOUNDED => $this->faker->year(),
            EmployerProfile::ADDRESS => $this->faker->address(),
            EmployerProfile::CITY => $this->faker->randomElement($country['states']),
            EmployerProfile::COUNTRY => $country['name'],
            EmployerProfile::IMAGE => $this->faker->randomElement(['https://placehold.co/300x250@2x.png', 'https://placehold.co/300x250?text=Hello+World&font=roboto']),
            EmployerProfile::FB_LINK => $this->faker->url(),
            EmployerProfile::TW_LINK => $this->faker->url(),
            EmployerProfile::IN_LINK => $this->faker->url(),
            EmployerProfile::LINKEDIN_LINK => $this->faker->url(),
            EmployerProfile::WEBSITE => $this->faker->url(),
        ];
    }
}
