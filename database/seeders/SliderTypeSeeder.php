<?php

namespace Database\Seeders;

use App\Models\SliderType;
use Illuminate\Database\Seeder;

class SliderTypeSeeder extends Seeder
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
                'type' => 'Ready Solutions',
            ],

            [
                'type' => 'Services',
            ]
        ];

        foreach($data as $item) {
            SliderType::firstOrCreate($item);
        }
    }
}
