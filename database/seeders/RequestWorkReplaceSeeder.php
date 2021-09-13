<?php

namespace Database\Seeders;

use App\Models\RequestRoomType;
use App\Models\RequestWorkReplace;
use App\Models\RequestWorkReplaceType;
use Illuminate\Database\Seeder;

class RequestWorkReplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kindCurrent = RequestWorkReplaceType::whereName('Current')->first()->id;

        $kindReplace = RequestWorkReplaceType::whereName('Replace')->first()->id;

        $bathroom = RequestRoomType::whereName('bathroom')->first()->id;

        $data = [
                ['room_type_id' => $bathroom, 'type' => 'Bathhub', 'type_id' => $kindCurrent],
                ['room_type_id' => $bathroom, 'type' => 'Walk-in Shower', 'type_id' => $kindCurrent],
                ['room_type_id' => $bathroom, 'type' => 'Walk-in Shower and Bathub', 'type_id' => $kindCurrent],
                ['room_type_id' => $bathroom, 'type' => 'New Bathhub', 'type_id' => $kindReplace],
                ['room_type_id' => $bathroom, 'type' => 'New Walk-in Shower', 'type_id' => $kindReplace],
                ['room_type_id' => $bathroom, 'type' => 'New Walk-in Shower and Bathub', 'type_id' => $kindReplace]
        ];

        foreach($data as $item) {
            RequestWorkReplace::firstOrCreate($item);
        }
    }
}
