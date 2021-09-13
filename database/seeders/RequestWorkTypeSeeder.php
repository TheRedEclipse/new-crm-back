<?php

namespace Database\Seeders;

use App\Models\RequestRoomType;
use App\Models\RequestWorkType;
use Illuminate\Database\Seeder;

class RequestWorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestWorkType::whereNotNull('id')->delete();

        $kitchen = RequestRoomType::whereName('kitchen')->first()->id;

        $bathroom = RequestRoomType::whereName('kitchen')->first()->id;

        $data = [
            [ 'name' => 'floor', 'title' => 'Floor', 'icon' => 'floor', 'room_type_id' => null, 'default' => true, ],
            [ 'name' => 'walls', 'title' => 'Walls', 'icon' => 'walls', 'room_type_id' => null, 'default' => true, ],
            [ 'name' => 'ceiling', 'title' => 'Ceiling', 'icon' => 'ceiling', 'room_type_id' => null, 'default' => true, ],
            [ 'name' => 'floor_tile', 'title' => 'Floor tile', 'icon' => 'floor-tile', 'room_type_id' => $kitchen, ],
            [ 'name' => 'wall_tile', 'title' => 'Wall tile', 'icon' => 'backsplash', 'room_type_id' => $kitchen, ],
            [ 'name' => 'toilet', 'title' => 'Toilet', 'icon' => 'toilet', 'room_type_id' => $kitchen, ],
            [ 'name' => 'recessed_light', 'title' => 'Recessed Light', 'icon' => 'recessed-light', 'type' => 'count', 'room_type_id' => null, ],
            [ 'name' => 'ceiling_light', 'title' => 'Ceiling Light', 'icon' => 'ceiling-light', 'type' => 'count', 'room_type_id' => null, ],
            [ 'name' => 'wall_light', 'title' => 'Wall Light', 'icon' => 'wall-light', 'type' => 'count', 'room_type_id' => null, ],
            [ 'name' => 'vanity', 'title' => 'Vanity / Sink', 'icon' => 'vanity', 'type' => 'count', 'room_type_id' => $kitchen, ],
            [ 'name' => 'interior_door', 'title' => 'Interior door', 'icon' => 'interior-door', 'type' => 'count', 'room_type_id' => null, ],
            [ 'name' => 'cabinet', 'title' => 'Cabinet', 'icon' => 'cabinet', 'type' => 'count', 'room_type_id' => $kitchen, ],
            [ 'name' => 'mirror', 'title' => 'Mirror', 'icon' => 'mirror', 'room_type_id' => $kitchen, ],
            [ 'name' => 'shower_door', 'title' => 'Shower door', 'icon' => 'shower-door', 'room_type_id' => $kitchen, ],
            [ 'name' => 'shower_curtain', 'title' => 'Shower curtain', 'icon' => 'shower-curtain', 'room_type_id' => $kitchen, ],
            [ 'name' => 'countertop', 'title' => 'Countertop', 'icon' => 'countertop', 'room_type_id' => $bathroom, ],
            [ 'name' => 'backsplash', 'title' => 'Backsplash', 'icon' => 'backsplash', 'room_type_id' => $kitchen, ],
            [ 'name' => 'wall_cabinets', 'title' => 'Wall cabinets', 'icon' => 'cabinet', 'room_type_id' => $kitchen, ],
            [ 'name' => 'base_cabinets', 'title' => 'Base cabinets', 'icon' => 'base-cabinet', 'room_type_id' => $kitchen, ],
            [ 'name' => 'stove', 'title' => 'Range / Stove', 'icon' => 'range', 'room_type_id' => $kitchen, ],
            [ 'name' => 'exhaust_hood', 'title' => 'Exhaust Hood', 'icon' => 'exhaust-hood', 'room_type_id' => $kitchen, ],
            [ 'name' => 'microwave', 'title' => 'Microwave', 'icon' => 'microwave', 'room_type_id' => $kitchen, ],
            [ 'name' => 'fridge', 'title' => 'Fridge', 'icon' => 'fridge', 'room_type_id' => $kitchen, ],
            [ 'name' => 'dishwasher', 'title' => 'Dishwasher', 'icon' => 'dishwasher', 'room_type_id' => $kitchen, ],
            [ 'name' => 'walkin_shower', 'title' => 'Walk-In shower', 'icon' => 'shower', 'room_type_id' => $bathroom, ],
            [ 'name' => 'bathub', 'title' => 'Bathub', 'icon' => 'bathub', 'type' => 'double', 'room_type_id' => $bathroom, ],
            [ 'name' => 'window', 'title' => 'Window', 'icon' => 'window', 'type' => 'count', 'room_type_id' => NULL, ],
        ];

        foreach($data as $item) {
            RequestWorkType::firstOrCreate($item);
        }
    }
}
