<?php

namespace App\Actions;

use App\Models\Attachment;
use App\Models\Request;
use App\Models\RequestHasRoom;
use App\Models\RequestRoomHasStyle;
use App\Models\RequestRoomHasWork;
use App\Models\RequestRoomHasWorkCountable;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateRoomAction
{
    use AsAction;

    public function handle($request_id, $data)
    {
        $room = RequestHasRoom::create([
            'request_id' => $request_id,
        ] + $data);

        foreach($data['styles'] as $style) {
            RequestRoomHasStyle::create([
                'room_id' => $room->id,
                'style_id' => $style['id'],
            ]);
        }
        
        foreach($data['works'] as $work) {
            RequestRoomHasWork::create([
                'room_id' => $room->id
            ] + $work);
        }

        // foreach($data['countable'] as $countable) {
        //     RequestRoomHasWorkCountable::create([
        //         'room_id' => $room->id
        //     ] + $countable);
        // }

        foreach($data['style_attachments'] as $styleAttachments) {
            Attachment::createWithRelation($data + [
                'model_id' => $room->id,
                'model_type' => RequestHasRoom::class,
                'url' => $styleAttachments['url'],
                'path'  => $styleAttachments['path']
            ]);
        }

        
        return $room;
    }
}
