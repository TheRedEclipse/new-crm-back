<?php

namespace Database\Seeders;

use App\Models\RequestWorkReplaceType;
use Illuminate\Database\Seeder;

class RequestWorkReplaceTypeSeeder extends Seeder
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
                'name' => 'current',
                'title'=> 'Current'
            ],

            [
                'name' => 'replace',
                'title'=> 'Replace'
            ]
        ];

        foreach($data as $item) {
            RequestWorkReplaceType::firstOrCreate($item);
        }
    }
}
