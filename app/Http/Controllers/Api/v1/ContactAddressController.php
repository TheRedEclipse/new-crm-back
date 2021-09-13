<?php

namespace App\Http\Controllers\Api\v1;

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

}
