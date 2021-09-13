<?php

namespace Database\Seeders;

use App\Models\PageType;
use Illuminate\Database\Seeder;

class PageTypeSeeder extends Seeder
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
                'type' => 'How We Work',
            ],

            [
                'type' => 'Why We Are Different',
            ]
        ];

        foreach($data as $item) {
            PageType::firstOrCreate($item);
        }
    }
}
