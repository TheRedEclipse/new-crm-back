<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\CreateLeadAction;
use App\Actions\CreateRoomAction;
use App\Http\Controllers\Controller;
use App\Http\Helpers\GoogleHelper;
use Illuminate\Http\Request as FormRequest;
use App\Http\Requests\Api\v1\RequestController\CreateRequest;
use App\Http\Requests\Api\v1\RequestController\UpdateRequest;
use App\Http\Requests\Api\v1\FilterRequest;
use App\Http\Requests\Api\v1\GetValuesByModelRequest;
use App\Http\Requests\Api\v1\RequestController\ChangeStatusRequest;
use App\Models\Address;
use App\Models\Lead;
use App\Models\Log;
use App\Models\Request;
use App\Models\Status;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:request.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:request.edit'])->only(['edit']);
        // $this->middleware(['auth:api', 'permission:request.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:request.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:request.destroy.soft'])->only(['destroy']);
    }


    /**
     * Постраничный список реквестов
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        if ($request->status) {
            $requests = Request::filters($request)
                ->with('createdBy')
                ->with('status')
                ->with('user')
                ->whereHas('status', function ($q) use ($request) {
                    $q->whereName($request->status);
                })
                ->with('stage')
                ->paginate($request->per_page ?? 30);
        } else {
            $statuses = Status::whereType('request')->orderBy('sort')->get();
            $requests = [];
            foreach ($statuses as $item) {
                $requests[$item->name] = Request::filters($request)
                    ->with('createdBy')
                    ->with('user')
                    ->with('status')
                    ->whereHas('status', function ($q) use ($item) {
                        $q->whereName($item->name);
                    })
                    ->with('stage')
                    ->paginate($request->per_page ?? 30);
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'requests' => $requests
            ]
        ]);
    }


    /**
     * Весь список реквестов
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'requests' => Request::with('createdBy')
                    ->with('status')
                    ->with('user')
                    ->with('stage')
                    ->get()
            ]
        ]);
    }


    /**
     * Создание реквеста
     *
     * @param  CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $user = request()->user('api');

        if (!$request->lead_id) {
            $lead = Lead::whereUserId($request->user_id)->first();
            if (!$lead) [$lead, $new_user] = CreateLeadAction::run($request, 'lead', false);
        }

        $userRequest = Request::createWithRelation($request->all() + [
            'model_type' => Lead::class,
            'model_id' => $request->lead_id ?? $lead->id,
            'status_id' => Status::getIdByTypeAndName('request', 'not_viewed'),
            'user_id' => $request->user_id ?? $new_user->id,
            'created_by_id' => $user->id ?? $new_user->id
        ]);

        Address::createWithRelation($request->all() + [
            'model_type' => Request::class,
            'model_id' => $userRequest->id,
        ]);

        foreach ($request->rooms as $room) {
            CreateRoomAction::run($userRequest->id, $room);
        }

        $user = $user ?? $new_user;
        Log::createWithRelation([
            'model_type' => Request::class,
            'model_id' => $userRequest->id,
            'log_type' => 'REQUEST_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} created a request #{$userRequest->id}",
            'user_message' => "You created a request #{$userRequest->id}"
        ]);


        // Get the API client and construct the service object.
        $client = new GoogleHelper();

        $service = new Google_Service_Sheets($client->getClient());

        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '1mzpSEfv4QEqSoWVXUVulGwawUy-cQc9HyjbhEnPTbvs';

        $range = 'Sheet1!A:S';

        // Create the value range Object
        $valueRange = new Google_Service_Sheets_ValueRange();

        $values = Request::whereId($userRequest->id)->with('questions')
            ->with('createdBy')
            ->with('status')
            ->with('user')
            ->with('buildingStage')
            ->with('buildingType')
            ->with('projectStageDate')
            ->with('stage')
            ->with('rooms')
            ->firstOrFail();

        $i = 0;

        $preparedArr = [];

        foreach ($values->rooms as $room) {
            $preparedArr[] = $room['length'];
            $preparedArr[] = $room['width'];
            $preparedArr[] = $room['height'];
            $preparedArr[] = $room['description'];
            $preparedArr[] = $room['pinterest_link'];

            foreach ($room->works as $key => $work) {
                if ($key === 0) {
                    array_push($preparedArr, ($work->workType['title'] ?? '') . "\n" . ($work->workAction['title'] ?? '') . "\n" . ($work->doubleCurrent['type'] ?? '') . "\n" . ($work->doubleReplace['type'] ?? ''));
                }

                if ($key > 0) {
                    $lastKey = array_key_last($preparedArr);

                    $preparedArr[$lastKey] .= "\n" . ($work->workType['title'] ?? '') . "\n" . ($work->workAction['title'] ?? '') . "\n" . ($work->doubleCurrent['type'] ?? '') . "\n" . ($work->doubleReplace['type'] ?? '');
                }
            }
            $i++;
        }

        $valueRange->setValues([$preparedArr]);

        $conf = ["valueInputOption" => "RAW"];

        $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf);

        return response()->json([
            'success' => true,
            'messages' => ["Request #{$userRequest->id} was created"],
            'data' => [
                'request' => $userRequest->id
            ]
        ]);
    }


    /**
     * Получение информации о реквесте для редактирования
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'request' => Request::whereId($id)
                    ->with('questions')
                    ->with('createdBy')
                    ->with('status')
                    ->with('user')
                    ->with('buildingStage')
                    ->with('buildingType')
                    ->with('projectStageDate')
                    ->with('stage')
                    ->with('rooms')
                    ->firstOrFail()
            ]
        ]);
    }

    public function view($id)
    {
        Request::whereId($id)->update([
            'status_id' => Status::getIdByTypeAndName('request', 'viewed'),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function changeStatus($id, ChangeStatusRequest $request)
    {
        $status = Status::getIdByTypeAndName('request', $request->status);
        if (!$status) {
            throw new \Exception('Unknown status');
        }

        Request::whereId($id)->update([
            'status_id' => $status,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Обновление реквеста
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $lead_request = Request::findOrFail($id);
        $lead_request->update($request->all());

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Request::class,
            'model_id' => $request->model_id ?? $lead_request->id,
            'log_type' => 'REQUEST_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated a request #{$lead_request->id}",
            'user_message' => "You updated a request #{$lead_request->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Request #{$lead_request->id} was updated"]
        ]);
    }

    /**
     * Удаление реквеста
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormRequest $request, $id)
    {
        $lead_request = Request::findOrFail($id);
        $lead_request->delete();

        $user = auth('api')->user();
        Log::createWithRelation([
            'model_type' => $request->model_type ?? Request::class,
            'model_id' => $request->model_id ?? $lead_request->id,
            'log_type' => 'REQUEST_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted a request #{$lead_request->id}",
            'user_message' => "You deleted a request #{$lead_request->id}"
        ]);

        return response()->json([
            'success' => true,
            'messages' => ["Request #{$lead_request->id} was deleted"]
        ]);
    }

    /**
     * Список реквестов для модели
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getValuesByModel(GetValuesByModelRequest $request)
    {
        if (!class_exists($request->model_type)) throw new \Exception('There is no model type');
        $model = $request->model_type::find($request->id);
        return response()->json([
            'success' => true,
            'data' => [
                'requests' => $model->requests ?? []
            ]
        ]);
    }
}
