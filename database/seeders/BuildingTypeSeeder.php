<?php

namespace Database\Seeders;

use App\Models\BuildingType;
use Illuminate\Database\Seeder;

class BuildingTypeSeeder extends Seeder
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
                'name' => 'apartment_building',
                'title' => 'Apartment building',
            ],
            [
                'name' => 'home',
                'title' => 'Single / Multi-family home',
            ],
        ];

        foreach($data as $item) {
            BuildingType::firstOrCreate($item);
        }
    }
}
