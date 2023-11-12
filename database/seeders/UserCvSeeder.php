<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserCv;
use Illuminate\Database\Seeder;

class UserCvSeeder extends Seeder
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
            UserCv::factory(rand(2, 3))->create([
                UserCv::USER_ID => $candidate->id,
            ]);
        }
    }
}
