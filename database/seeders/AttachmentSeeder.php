<?php

namespace Database\Seeders;

use App\Models\Attachment;
use Illuminate\Database\Seeder;

class attachmentseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Attachment::where(['description' => 'building-type-1'])->delete();
        Attachment::where(['description' => 'building-type-2'])->delete();
        Attachment::where(['description' => 'building-type-3'])->delete();
        Attachment::where(['description' => 'building-type-4'])->delete();

        $data = [
            [
                'url' => 'https://api.modernciti.group/storage/building-type-1.png',
                'description' => 'building-type-1'
            ],
            [
                'url' => 'https://api.modernciti.group/storage/building-type-2.png',
                'description' => 'building-type-2'
            ],
            [
                'url' => 'https://api.modernciti.group/storage/building-type-3.png',
                'description' => 'building-type-3'
            ],
            [
                'url' => 'https://api.modernciti.group/storage/building-type-4.png',
                'description' => 'building-type-4'
            ],
        ];

        foreach($data as $item) {
            Attachment::firstOrCreate($item);
        }
    }
}
