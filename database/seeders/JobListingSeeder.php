<?php

namespace Database\Seeders;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employers = User::where(User::ROLE, User::ROLE_EMPLOYER)->get();

        foreach ($employers as $employer) {
            JobListing::factory(rand(5, 10))->create([
                JobListing::USER_ID => $employer->id
            ]);
        }
    }
}
