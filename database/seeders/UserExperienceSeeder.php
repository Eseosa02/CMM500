<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserExperience;
use Illuminate\Database\Seeder;

class UserExperienceSeeder extends Seeder
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
            UserExperience::factory(rand(1, 3))->create([
                UserExperience::USER_ID => $candidate->id
            ]);
        }
    }
}
