<?php

namespace Database\Factories;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $skillsOptions = [array('Design','React','Laravel'), array('Android','Design','Devops'), array('SQL', 'Data Analysis', 'Laravel','Wordpress'), array('Jira', 'JavaScript')];
        $skills = $skillsOptions[array_rand($skillsOptions)];
        $ratings = $this->handleRatingData($skills, []);
        $description = implode('<br><br>', [$this->faker->text(random_int(500, 800)), $this->faker->text(random_int(500, 800))]);
        $country = (new Controller)->getCountries()[array_rand((new Controller)->getCountries())];
        
        
        return [
            UserProfile::UNIQUE_ID => Str::random(25),
            UserProfile::TITLE => Str::title(implode(' ', $this->faker->words(4))),
            UserProfile::PHONE => $this->faker->phoneNumber(),
            UserProfile::DESCRIPTION => $description,
            UserProfile::DOB => $this->faker->date(),
            UserProfile::IMAGE => $this->faker->randomElement(['https://placehold.co/300x250@2x.png', 'https://placehold.co/300x250?text=Hello+World&font=roboto']),
            UserProfile::GENDER => $this->faker->randomElement(['male', 'female', 'others']),
            UserProfile::EXPERIENCE => $this->faker->randomElement(['0 - 2', '2 - 4', '5+']),
            UserProfile::EDUCATION => $this->faker->randomElement(['Bachelor of Science', 'Master of Science', 'Doctor of Philosophy']),
            UserProfile::CITY => $this->faker->randomElement($country['states']),
            UserProfile::SKILLS => $skills,
            UserProfile::RATING => $ratings,
            UserProfile::COUNTRY => $country['name'],
            UserProfile::FB_LINK => $this->faker->url(),
            UserProfile::TW_LINK => $this->faker->url(),
            UserProfile::IN_LINK => $this->faker->url(),
            UserProfile::LINKEDIN_LINK => $this->faker->url(),
            UserProfile::WEBSITE => $this->faker->url(),
            UserProfile::SEXUAL_ORIENTATION => $this->faker->randomElement(['Heterosexual', 'Gay', 'Lesbian', 'Bisexual', 'Prefer not to say']),
            UserProfile::DISABILITY => $this->faker->randomElement(['Yes', 'No', 'Prefer not to say']),
            UserProfile::RELIGION => $this->faker->randomElement(['Christianity', 'Buddhist', 'Muslim', 'Hindu', 'Other', 'Prefer not to say']),
        ];
    }

    public function handleRatingData($skills, $ratings) {
        $formattedRatings = [];
        $ratingsValue = $this->defaultRatings(collect($skills)->count());
        if (collect($ratings)->count() === 0) {
            $formattedRatings = array_combine($skills, $ratingsValue);
        } else {
            foreach ($skills as $skill) {
                if (isset($ratings[$skill])) {
                    $formattedRatings[$skill] = $ratings[$skill];
                } else {
                    $formattedRatings[$skill] = rand(1, 5);
                }
            }
        }
        return $formattedRatings;
    }

    public function defaultRatings($count) {
        $ratings = [];
        for ($i=0; $i < $count; $i++) { 
            $ratings[] = rand(1, 5);
        }
        return $ratings;
    }
}
