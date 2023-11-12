<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\JobListing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = $this->getIds(Category::get('id'));
        $title = $this->faker->jobTitle();

        $skillsOptions = [array('Design','React','Laravel'), array('Android','Design','Devops'), array('SQL', 'Data Analysis', 'Laravel','Wordpress'), array('Jira', 'JavaScript')];
        $skills = $skillsOptions[array_rand($skillsOptions)];

        $description = implode('<br><br>', [$this->faker->text(random_int(500, 800)), $this->faker->text(random_int(500, 800)), $this->faker->text(random_int(500, 800))]);
        $country = (new Controller)->getCountries()[array_rand((new Controller)->getCountries())];

        return [
            JobListing::CATEGORY_ID => $this->faker->randomElement($categories),
            JobListing::JOB_REFERENCE => Str::random(25),
            JobListing::TITLE => $title,
            JobListing::TITLE_SLUG => Str::slug($title, '-') . '-' . rand(10000000, 99999999),
            JobListing::DESCRIPTION => $description,
            JobListing::CONTRACT_TYPE => $this->faker->randomElement(['contract', 'full time', 'part time', 'internship', 'freelance']),
            JobListing::CITY => $this->faker->randomElement($country['states']),
            JobListing::PRIORITY => $this->faker->randomElement(['urgent', 'medium', 'low']),
            JobListing::EXPERIENCE => $this->faker->randomElement([array('2 - 4', '5+'), array('0 - 2','2 - 4'), array('2 - 4'), array('5+')]),
            JobListing::COUNTRY => $country['name'],
            JobListing::SALARY => $this->faker->randomElement(['£25k - £30k', '£250k - £300k', '£105k - £180k', '£45k - £80k']),
            JobListing::EXPIRY_DATE => $this->faker->dateTimeInInterval(now(), '+6 months'),
            JobListing::HOURS => random_int(25, 50),
            JobListing::SKILLS => $skills,
            JobListing::VIEWS => random_int(800, 25000),
            JobListing::STATUS => 'open',
        ];
    }

    public function getIds($categories) {
        $categoryIds = [];
        foreach ($categories as $category) {
            array_push($categoryIds, $category->id);
        }
        return $categoryIds;
    }
}
