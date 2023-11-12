<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class CandidateProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $candidates = User::where(User::ROLE, User::ROLE_CANDIDATE)->get();

        foreach ($candidates as $candidate) {
            UserProfile::factory()->create([
                UserProfile::USER_ID => $candidate->id
            ]);
        }
    }
}
