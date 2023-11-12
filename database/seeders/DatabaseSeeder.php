<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            CandidateProfileSeeder::class,
            EmployerProfileSeeder::class,
            UserEducationSeeder::class,
            UserExperienceSeeder::class,
            UserCvSeeder::class,
            JobListingSeeder::class,
            JobApplicationSeeder::class,
            FeedbackSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
