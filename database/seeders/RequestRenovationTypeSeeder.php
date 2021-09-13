<?php

namespace Database\Seeders;

use App\Models\RequestRenovationType;
use Illuminate\Database\Seeder;

class RequestRenovationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'full_renovation', 'title' => 'Full renovation', ],
        ];

        foreach($data as $item) {
            RequestRenovationType::firstOrCreate($item);
        }
    }
}
