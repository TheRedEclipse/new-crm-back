<?php

namespace Database\Seeders;

use App\Models\RequestWorkReplace;
use App\Models\RequestWorkReplaceType;
use App\Models\RequestWorkType;
use App\Models\RequestWorkTypeHasRequestWorkReplace;
use Illuminate\Database\Seeder;

class RequestWorkTypeHasRequestWorkReplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        RequestWorkTypeHasRequestWorkReplace::where(['replace_id' => RequestWorkReplace::whereType('Bathhub')->first()->id])->delete();
        
        RequestWorkTypeHasRequestWorkReplace::where(['replace_id' => RequestWorkReplace::whereType('Walk-in Shower')->first()->id])->delete();

        RequestWorkTypeHasRequestWorkReplace::where(['replace_id' => RequestWorkReplace::whereType('Walk-in Shower and Bathub')->first()->id])->delete();

        RequestWorkTypeHasRequestWorkReplace::where(['replace_id' => RequestWorkReplace::whereType('New Bathhub')->first()->id])->delete();

        RequestWorkTypeHasRequestWorkReplace::where(['replace_id' => RequestWorkReplace::whereType('New Walk-in Shower')->first()->id])->delete();

        RequestWorkTypeHasRequestWorkReplace::where(['replace_id' => RequestWorkReplace::whereType('New Walk-in Shower and Bathub')->first()->id])->delete();

        $model = RequestWorkType::class;

        $kindCurrent = RequestWorkReplaceType::whereName('Current')->first()->id;

        $kindReplace = RequestWorkReplaceType::whereName('Replace')->first()->id;

        $workType = RequestWorkType::whereName('bathub')->first()->id;

        $data = [
        ['replace_id' => RequestWorkReplace::whereType('Bathhub')->first()->id, 'model_id' => $workType, 'model_type' => $model, 'type_id' => $kindCurrent],
        ['replace_id' => RequestWorkReplace::whereType('Walk-in Shower')->first()->id, 'model_id' => $workType, 'model_type' => $model, 'type_id' => $kindCurrent],
        ['replace_id' => RequestWorkReplace::whereType('Walk-in Shower and Bathub')->first()->id, 'model_id' => $workType, 'model_type' => $model, 'type_id' => $kindCurrent],
        ['replace_id' => RequestWorkReplace::whereType('New Bathhub')->first()->id, 'model_id' => $workType, 'model_type' => $model, 'type_id' => $kindReplace],
        ['replace_id' => RequestWorkReplace::whereType('New Walk-in Shower')->first()->id, 'model_id' => $workType, 'model_type' => $model, 'type_id' => $kindReplace],
        ['replace_id' => RequestWorkReplace::whereType('New Walk-in Shower and Bathub')->first()->id, 'model_id' => $workType, 'model_type' => $model, 'type_id' => $kindReplace],
        
        ];

        foreach($data as $item) {
            RequestWorkTypeHasRequestWorkReplace::firstOrCreate($item);
        }
    }
}
