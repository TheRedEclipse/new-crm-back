<?php

namespace Database\Seeders;

use App\Models\ProjectStageDate;
use Illuminate\Database\Seeder;

class ProjectStageDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'month',
                'title' => 'In 1 month',
                'seconds' => 2592000
            ],
            [
                'name' => 'as_soon_as_possible',
                'title' => 'As soon as possible',
                'seconds' => 2592000
            ],
            [
                'name' => 'in_2_months',
                'title' => 'In 2 months',
                'seconds' => 2592000
            ],
            [
                'name' => 'in_3_6_months',
                'title' => 'In 3-6 months',
                'seconds' => 2592000
            ],
            [
                'name' => 'not_sure',
                'title' => 'Not sure',
                'seconds' => 2592000
            ],
        ];

        foreach($data as $item) {
            ProjectStageDate::firstOrCreate($item);
        }
    }
}
