<?php

namespace Database\Seeders;

use App\Models\SlideType;
use Illuminate\Database\Seeder;

class SlideTypeSeeder extends Seeder
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
                'title' => 'Main Slider',
            ],
            [
                'name' => 'how_we_work',
                'title' => 'How we work Slider',
            ],
            [
                'name' => 'why_we_are_different',
                'title' => 'Why we are different Slider',
            ],
            [
                'name' => 'stages',
                'title' => 'Stages slider',
            ],
            [
                'name' => 'stages_instagrammable',
                'title' => 'Stages slider (like in Instagram)',
            ],
            [
                'name' => 'about',
                'title' => 'About slider',
            ]
        ];

        foreach($data as $item) {
            SlideType::firstOrCreate($item);
        }
    }
}
