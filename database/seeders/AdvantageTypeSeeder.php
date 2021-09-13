<?php

namespace Database\Seeders;

use App\Models\AdvantageType;
use Illuminate\Database\Seeder;

class AdvantageTypeSeeder extends Seeder
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
                'type' => 'Advantage',
            ]
        ];

        foreach($data as $item) {
            AdvantageType::firstOrCreate($item);
        }

    }
}
