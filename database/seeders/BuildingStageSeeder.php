<?php

namespace Database\Seeders;

use App\Models\BuildingStage;
use Illuminate\Database\Seeder;

class BuildingStageSeeder extends Seeder
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
                'name' => 'property',
                'title' => 'I own the property',
            ],
            [
                'name' => 'contact',
                'title' => 'I\'m in contact for the property',
            ],
            [
                'name' => 'purchase',
                'title' => 'I\'m thinking of purchasing the property',
            ],
            [
                'name' => 'other',
                'title' => 'Other',
            ],
        ];

        foreach($data as $item) {
            BuildingStage::firstOrCreate($item);
        }
    }
}
