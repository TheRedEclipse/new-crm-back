<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
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
                // 1
                'name' => 'not_viewed',
                'title' => 'Not viewed',
                'type' => 'request',
                'color' => '#FF647C',
                'parent_id' => null,
                'sort' => 1,
            ],
            [
                // 2
                'name' => 'viewed',
                'title' => 'Viewed',
                'type' => 'request',
                'color' => '#EFDA1C',
                'parent_id' => 1,
                'sort' => 2,
            ],
            [
                // 3
                'name' => 'pending_information',
                'title' => 'Pending information',
                'type' => 'request',
                'color' => '#EFDA1C',
                'parent_id' => 2,
                'sort' => 3,
            ],
            [
                // 4
                'name' => 'estimated',
                'title' => 'Estimated',
                'type' => 'request',
                'color' => '#2ED47A',
                'parent_id' => 3,
                'sort' => 4,
            ],
            [
                // 5
                'name' => 'initial_proposal',
                'title' => 'Initial proposal & design',
                'type' => 'estimate',
                'color' => '#FF647C',
                'parent_id' => null,
                'sort' => 1,
            ],
            [
                // 6
                'name' => 'walk_through',
                'title' => 'Walk through',
                'type' => 'estimate',
                'color' => '#EFDA1C',
                'parent_id' => 5,
                'sort' => 2,
            ],
            [
                // 7
                'name' => 'final_proposal',
                'title' => 'Final proposal & design',
                'type' => 'estimate',
                'color' => '#2ED47A',
                'parent_id' => 6,
                'sort' => 3,
            ],
            [
                // 8
                'name' => 'contract',
                'title' => 'Contract',
                'type' => 'estimate',
                'color' => '#2ED47A',
                'parent_id' => 7,
                'sort' => 4,
            ],
        ];

        foreach($data as $item) {
            Status::firstOrCreate($item);
        }
    }
}
