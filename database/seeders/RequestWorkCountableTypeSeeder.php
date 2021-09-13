<?php

namespace Database\Seeders;

use App\Models\RequestWorkCountableType;
use App\Models\RequestWorkType;
use Illuminate\Database\Seeder;

class RequestWorkCountableTypeSeeder extends Seeder
{
    public function run()
    {
        $recessed_light_id = RequestWorkType::whereName('recessed_light')->first()->id;
        $ceiling_light_id = RequestWorkType::whereName('ceiling_light')->first()->id;
        $wall_light_id = RequestWorkType::whereName('wall_light')->first()->id;
        $data = [
            [ 'work_type_id' => $recessed_light_id, 'name' => 'recessed_light', 'title' => 'Recessed Light', 'icon' => 'recessed_light', 'sort' => 1, ],
            [ 'work_type_id' => $ceiling_light_id, 'name' => 'wall_fixture', 'title' => 'Wall Fixture', 'icon' => 'wall_fixture', 'sort' => 2, ],
            [ 'work_type_id' => $wall_light_id, 'name' => 'ceiling_fixture', 'title' => 'Ceiling Fixture', 'icon' => 'ceiling_fixture', 'sort' => 3, ],
        ];

        foreach($data as $item) {
            RequestWorkCountableType::firstOrCreate($item);
        }
    }
}
