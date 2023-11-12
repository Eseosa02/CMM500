<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $joblistings = $this->getIds(JobListing::inRandomOrder()->get('id'));

        foreach ($joblistings as $listing) {
            $applicants = User::where(User::ROLE, User::ROLE_CANDIDATE)->inRandomOrder()->take(random_int(3, 5))->get('id');
            foreach ($applicants as $applicant) {
                if (count($applicant->candidateCVs) > 0) {
                    JobApplication::factory()->create([
                        JobApplication::JOB_LISTING_ID => $listing,
                        JobApplication::USER_ID => $applicant->id,
                        JobApplication::CV_ID => $applicant->candidateCVs->shuffle()->first()->id,
                    ]);
                }
            }
        }
    }

    public function getIds($payload) {
        $ids = [];
        foreach ($payload as $value) {
            array_push($ids, $value->id);
        }
        return $ids;
    }
}
