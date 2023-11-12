<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserEducation;
use Illuminate\Database\Seeder;

class UserEducationSeeder extends Seeder
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
            UserEducation::factory(rand(1, 3))->create([
                UserEducation::USER_ID => $candidate->id
            ]);
        }
    }
}
