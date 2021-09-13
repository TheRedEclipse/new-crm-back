<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
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
                'title' => 'How We Work',
                'type_id' => '1',
                'slug' => 'how-we-work'
            ],

            [
                'title' => 'Why We Are Different',
                'type_id' => '2',
                'slug' => 'why-we-are-different'
            ]
        ];

        foreach($data as $item) {
            Page::firstOrCreate($item);
        }
    }
}
