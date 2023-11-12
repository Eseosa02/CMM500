<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Accounting / Finance',
            'Audit',
            'Automative Jobs',
            'Business Administration',
            'Technology',
            'Finance',
            'HR Management',
            'Project Management',
            'Marketing',
            'Design',
            'Development',
            'Health & Care',
        ];

        foreach ($categories as $category) {
            Category::factory()->create([
                Category::TITLE => $category,
            ]);
        }
    }
}
