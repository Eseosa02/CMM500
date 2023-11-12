<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $joblistings = $this->getIds(JobListing::inRandomOrder()->take(random_int(5, 10))->get('id'));

        foreach ($joblistings as $listing) {
            $applicants = User::where(User::ROLE, User::ROLE_CANDIDATE)->inRandomOrder()->take(random_int(2, 5))->get('id');
            foreach ($applicants as $applicant) {
                if (count($applicant->candidateCVs) > 0) {
                    Feedback::factory()->create([
                        Feedback::JOB_LISTING_ID => $listing,
                        Feedback::USER_ID => $applicant->id,
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
