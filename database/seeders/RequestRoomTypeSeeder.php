<?php

namespace Database\Seeders;

use App\Models\RequestRoomType;
use Illuminate\Database\Seeder;

class RequestRoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'kitchen', 'title' => 'Kitchen', 'icon' => 'kitchen', ],
            [ 'name' => 'bathroom', 'title' => 'Bathroom', 'icon' => 'bathroom', ],
            [ 'name' => 'living_room', 'title' => 'Living room', 'icon' => 'living-room', ],
            [ 'name' => 'master_bedroom', 'title' => 'Master bedroom', 'icon' => 'master-bedroom', ],
            [ 'name' => 'guest_bedroom', 'title' => 'Guest bedroom', 'icon' => 'guest-bedroom', ],
            [ 'name' => 'dinning_room', 'title' => 'Dinning room', 'icon' => 'dinning-room', ],
            [ 'name' => 'other', 'title' => 'Other', 'icon' => 'other', ],
            [ 'name' => 'hallway', 'title' => 'Hallway', 'icon' => 'hallway', ],
            [ 'name' => 'office', 'title' => 'Office', 'icon' => 'office', ],
            [ 'name' => 'den', 'title' => 'Den', 'icon' => 'den', ],
            [ 'name' => 'nursery', 'title' => 'Nursery', 'icon' => 'nursery', ],
            [ 'name' => 'basement', 'title' => 'Basement', 'icon' => 'basement', ],
        ];

        foreach($data as $item) {
            RequestRoomType::firstOrCreate($item);
        }
    }
}
