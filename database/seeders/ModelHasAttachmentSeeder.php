<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\BuildingStage;
use App\Models\BuildingType;
use App\Models\ModelHasAttachment;
use Illuminate\Database\Seeder;

class ModelHasAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $modelStage = BuildingStage::class;

        $modelType = BuildingType::class;

        $attachmentOne = Attachment::whereDescription('building-type-1')->first()->id;

        $attachmentTwo = Attachment::whereDescription('building-type-2')->first()->id;

        $attachmentThree = Attachment::whereDescription('building-type-3')->first()->id;

        $attachmentFour = Attachment::whereDescription('building-type-4')->first()->id;

        $data = [
            [
                'attachment_id' => $attachmentOne,
                'model_id' => BuildingStage::whereName('property')->first()->id,
                'model_type' => $modelStage
            ],
            [
                'attachment_id' => $attachmentTwo,
                'model_id' => BuildingStage::whereName('contact')->first()->id,
                'model_type' => $modelStage
            ],
            [
                'attachment_id' => $attachmentThree,
                'model_id' => BuildingStage::whereName('purchase')->first()->id,
                'model_type' => $modelStage
            ],
            [
                'attachment_id' => $attachmentFour,
                'model_id' => BuildingStage::whereName('other')->first()->id,
                'model_type' => $modelStage
            ],
            [
                'attachment_id' => $attachmentOne,
                'model_id' => BuildingType::whereName('apartment_building')->first()->id,
                'model_type' => $modelType
            ],
            [
                'attachment_id' => $attachmentFour,
                'model_id' => BuildingType::whereName('home')->first()->id,
                'model_type' => $modelType
            ],
        ];

        foreach($data as $item) {
            ModelHasAttachment::firstOrCreate($item);
        }
    }
}
