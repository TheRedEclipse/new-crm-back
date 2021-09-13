<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ContactAddress\IndexContactAddressRequest;
use App\Http\Requests\Api\v1\ContactAddress\StoreContactAddressRequest;
use App\Http\Requests\Api\v1\ContactAddress\UpdateContactAddressRequest;
use App\Models\ContactAddress;
use App\Services\ContactAddressService;

class ContactAddressController extends Controller
{

    protected $contactAddressService;
    protected $contactAddress;

    public function __construct(ContactAddressService $contactAddressService, ContactAddress $contactAddress)
    {

        $this->contactAddressService = $contactAddressService;
        $this->contactAddress = $contactAddress;

        $this->middleware(['auth:api', 'permission:admin.contact_address.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.contact_address.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.contact_address.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.contact_address.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.contact_address.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexContactAddressRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'contact_addresses' => $this->contactAddressService->index($request),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactAddressRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'contact_address_id' => $this->contactAddressService->store($request),
            ],
            'messages' => [__('messages.contact_address.store')]

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if ($this->contactAddress->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'contact_address' => $this->contactAddressService->show($id),
                ]
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactAddressRequest $request, $id)
    {

        if ($this->contactAddress->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'contact_address_id' => $this->contactAddressService->update($request, $id),
                ],
                'messages' => [__('messages.contact-address.update')]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if ($this->contactAddress->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'contact_address_id' => $this->contactAddressService->destroy($id),
                ],
                'messages' => [__('messages.contact_address.destroy')]
            ]);
        }
    }
}
