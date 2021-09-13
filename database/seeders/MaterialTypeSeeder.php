<?php

namespace Database\Seeders;

use App\Models\MaterialType;
use Illuminate\Database\Seeder;

class MaterialTypeSeeder extends Seeder
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
                'name' => 'Main Materials',
                'title' => 'Main Materials',
                'icon' => 'icon'
            ],
            [
                'name' => 'Additional Materials',
                'title' => 'Additional Materials',
                'icon' => 'icon'
            ],
        ];

        foreach($data as $item) {
            MaterialType::firstOrCreate($item);
        }
    }
}
