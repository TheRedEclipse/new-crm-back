<?php

namespace Database\Seeders;

use App\Models\RequestRoomStyle;
use App\Models\RequestRoomType;
use Illuminate\Database\Seeder;

class RequestRoomStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'image' => 'https://regodesign.ru/assets/images/blog/paris/09.jpg', 'sort' => 1, ],
            [ 'image' => 'https://img2.goodfon.ru/wallpaper/big/2/98/komnata-divan-kinozal.jpg', 'sort' => 2, ],
            [ 'image' => 'https://images.by.prom.st/183793351_w640_h640_ukladka-parketnoj-doski.jpg', 'sort' => 3, ],
            [ 'image' => 'https://tvojdizajn.ru/sites/default/files/styles/870w/public/inline/images/ceilings_from_plasterboard_for_the_living_room_2.jpg', 'sort' => 4, ],
            [ 'image' => 'https://novolitika.ru/wp-content/uploads/2017/01/12-11-06_112_rd-600x400.jpg', 'sort' => 5, ],
            [ 'image' => 'https://i.pinimg.com/736x/a1/60/04/a160044d0d01388455e1106fa9928a82.jpg', 'sort' => 6, ],
            [ 'image' => 'http://img1.liveinternet.ru/images/attach/c/2/67/694/67694119_ef5cc58ff1f7.jpg', 'sort' => 7, ],
            [ 'image' => 'https://i.pinimg.com/736x/0b/dd/e2/0bdde28eade584918d944037e7b3b112.jpg', 'sort' => 8, ],
        ];

        $room_types = RequestRoomType::all();

        foreach($room_types as $type) {
            foreach($data as $item) {
                RequestRoomStyle::firstOrCreate($item + [ 'room_type_id' => $type->id ]);
            }
        }
    }
}
