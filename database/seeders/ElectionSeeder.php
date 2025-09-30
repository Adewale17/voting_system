<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Election;

class ElectionSeeder extends Seeder
{
    public function run()
    {
        Election::create([
            'title' => 'Student Council 2025',
            'description' => 'Election for the Student Council 2025',
            'start_date' => '2025-10-01',
            'end_date' => '2025-10-07',
            'status' => 'upcoming',
        ]);

        Election::create([
            'title' => 'Department Rep 2025',
            'description' => 'Election for Department Representatives 2025',
            'start_date' => '2025-11-01',
            'end_date' => '2025-11-05',
            'status' => 'upcoming',
        ]);

        Election::create([
            'title' => 'Sports Committee 2025',
            'description' => 'Election for Sports Committee Members 2025',
            'start_date' => '2025-12-01',
            'end_date' => '2025-12-05',
            'status' => 'ongoing',
        ]);
    }
}
