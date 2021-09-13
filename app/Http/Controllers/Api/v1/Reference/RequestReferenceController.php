<?php

namespace App\Http\Controllers\Api\v1\Reference;

use App\Exceptions\EmptyException;
use App\Http\Controllers\Controller;
use App\Models\AdvantageType;
use App\Models\ProjectStageDate;
use App\Models\RequestRenovationType;
use App\Models\RequestRoomStyle;
use App\Models\RequestRoomType;
use App\Models\RequestWorkAction;
use App\Models\RequestWorkCountableType;
use App\Models\RequestWorkReplaceType;
use App\Models\RequestWorkType;
use App\Models\RequestWorkTypeHasRequestWorkReplace;
use App\Models\SlideType;
use App\Models\Status;

class RequestReferenceController extends Controller
{
    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getStatuses()
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'statuses' => Status::whereType('request')->orderBy('sort')->get(),
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getProjectStageDates()
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'project_stage_dates' => ProjectStageDate::all(),
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getRenovationTypes()
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'renovation_types' => RequestRenovationType::all(),
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getRoomStyles($room_type_id = null)
    {
        $room_styles = RequestRoomStyle::query();
        if ($room_type_id) {
            $room_styles->whereRoomTypeId($room_type_id);
        }

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'room_styles' => $room_styles->get(),
                ],
            ]
        );
    }

    public function getRoomDouble($action_type, $work_type_id)
    {
        if ($action_type !== 'current' && $action_type !== 'replace') {
            throw new EmptyException('Wrong type.');
        }

        RequestWorkTypeHasRequestWorkReplace::where(['model_id' => $work_type_id, 'type_id' => RequestWorkReplaceType::whereName($action_type)->first()->id])->firstOrFail();

        $room = RequestWorkType::where(['id' => $work_type_id])->with('double' . $action_type)->first();

        $works = [];

        $i = 0;

        foreach ($room['double' . $action_type] as $work) {
            $works[$i++] = [
                'id' => $work['id'],
                'room_type_id' => $work['room_type_id'],
                'title' => $work['type'],
            ];
        }

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'room_double_' . $action_type => $works,
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getRoomTypes()
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'room_types' => RequestRoomType::all(),
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getWorkTypes($work_type_id = null)
    {
        if ($work_type_id) {
            $workTypes = RequestWorkType::whereRoomTypeId($work_type_id)->orWhere('room_type_id', '=', null)->get();
        } else {
            $workTypes = RequestWorkType::all();
        }

        $filtered = array_filter(array_map('array_filter', $workTypes->toArray()));

        $i = 0;

        $workTypes = [];

        foreach ($filtered as $var) {
            $workTypes[$i] = [
                'id' => $var['id'],
                'name' => $var['name'],
                'title' => $var['title'],
                'icon' => $var['icon'],
                'type' => $var['type'],
            ];

            if ($var['type'] === 'count') {
                $workTypes[$i]['quantity'] = 1;
            }

            if ($var['type'] === 'double') {
                $workTypes[$i]['double_current'] = [];

                $workTypes[$i]['double_install'] = [];
            }

            if (isset($var['default'])) {
                $workTypes[$i]['default'] = true;
            }

            $i++;
        }

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'work_types' => $workTypes,
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getWorkActions()
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'work_actions' => RequestWorkAction::all(),
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getAdvantageTypes()
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'advantage_types' => AdvantageType::all(),
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getSlideTypes()
    {
        return response()->json(
            [
                'success' => true,
                'data' => [
                    'slide_types' => SlideType::all(),
                ],
            ]
        );
    }

    /**
     * Данные справочника
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getWorkCountableTypes($work_type_id = null)
    {
        $work_countable_types = RequestWorkCountableType::query();
        if ($work_type_id) {
            $work_countable_types->whereWorkTypeId($work_type_id)->orWhere('work_type_id', '=', null);
        }

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'work_countable_types' => $work_countable_types->get(),
                ],
            ]
        );
    }
}
