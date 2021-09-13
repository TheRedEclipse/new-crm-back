<?php

namespace App\Services;

use App\Models\ContactAddress;
use App\Models\Log;
use Carbon\Carbon;

class ContactAddressService
{
    protected $contactAddress;

    public function __construct(ContactAddress $contactAddress)
    {

        $this->contactAddress = $contactAddress;

    }

    public function index(object $request)
    {
        $query = $this->contactAddress->with('state');

        if(isset($request->filters['state'])) {
            $query->whereHas('state', function($query) use ($request) {
                return $query->where('name', '=', $request->filters['state']);
            });
        }

        return (int) $request->per_page ? $query->paginate($request->per_page) : $query->get();
    }

    public function store(object $request)
    {

        $user = auth('api')->user();

        $model = ContactAddress::class;

        $contactAddress = $this->contactAddress->create($request->validated());

        Log::createWithRelation([
            'model_type' => $request->model_type ?? $model,
            'model_id' => $request->model_id ?? $contactAddress->id,
            'log_type' => 'CONTACT_ADDRESS_CREATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated created contact address #{$contactAddress->id}",
            'user_message' => "You've created contact address #{$contactAddress->id}"
        ]);

        return $contactAddress->id;
    }

    public function show(int $id)
    {

        return $this->contactAddress->where('id', $id)->get();
    }

    public function update(object $request, int $id)
    {

        $user = auth('api')->user();

        $model = ContactAddress::class;

        $this->contactAddress->where('id', $id)->update($request->validated());

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'CONTACT_ADDRESS_UPDATE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} updated contact address #{$id}",
            'user_message' => "You've updated contact address #{$id}"
        ]);

        return $id;
    }

    public function destroy(int $id)
    {

        $user = auth('api')->user();
        $model = ContactAddress::class;

        $this->contactAddress->where('id', $id)->update(['deleted_at' => Carbon::now()->toDateTimeString()]);

        Log::createWithRelation([
            'model_type' => $model,
            'model_id' => $id,
            'log_type' => 'CONTACT_ADDRESS_DELETE',
            'from_user_id' => $user->id,
            'message' => "User {$user->name} {$user->last_name} deleted contact address #{$id}",
            'user_message' => "You've deleted contact address #{$id}"
        ]);

        return $id;
    }
}
