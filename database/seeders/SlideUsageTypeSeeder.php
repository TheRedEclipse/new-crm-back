<?php

namespace Database\Seeders;

use App\Models\SlideUsageType;
use Illuminate\Database\Seeder;

class SlideUsageTypeSeeder extends Seeder
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
                'name' => 'main_slider',
                'title' => 'Main slider',
            ],
            [
                'name' => 'page_slider',
                'title' => 'Slide in page',
            ],
        ];

        foreach($data as $item) {
            SlideUsageType::firstOrCreate($item);
        }
    }
}
