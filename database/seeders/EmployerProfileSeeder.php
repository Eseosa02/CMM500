<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\EmployerProfile;
use Illuminate\Database\Seeder;

class EmployerProfileSeeder extends Seeder
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
            EmployerProfile::factory()->create([
                EmployerProfile::USER_ID => $employer->id
            ]);
        }
    }
}
