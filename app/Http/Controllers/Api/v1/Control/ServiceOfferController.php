<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ServiceOffer\IndexServiceOfferRequest;
use App\Http\Requests\Api\v1\ServiceOffer\StoreServiceOfferRequest;
use App\Http\Requests\Api\v1\ServiceOffer\UpdateServiceOfferRequest;
use App\Models\ServiceOffer;
use App\Services\ServiceOfferService;

class ServiceOfferController extends Controller
{

    protected $serviceOfferService;
    protected $serviceOffer;

    public function __construct(ServiceOfferService $serviceOfferService, ServiceOffer $serviceOffer)
    {

        $this->serviceOfferService = $serviceOfferService;
        $this->serviceOffer = $serviceOffer;

        $this->middleware(['auth:api', 'permission:admin.service_offer.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.service_offer.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.service_offer.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.service_offer.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.service_offer.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexServiceOfferRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'service_offers' => $this->serviceOfferService->index($request),
            ]

        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {

        return response()->json([

            'success' => true,
            'data' => [
                'services' => $this->serviceOffer->all(),
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
    public function store(StoreServiceOfferRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'service_offer_id' => $this->serviceOfferService->store($request),
            ],
            'messages' => [__('messages.service_offer.store')]

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

        if ($this->serviceOffer->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'service_offer' => $this->serviceOfferService->show($id),
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
    public function update(UpdateServiceOfferRequest $request, $id)
    {

        if ($this->serviceOffer->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'service_offer_id' => $this->serviceOfferService->update($request, $id),
                ],
                'messages' => [__('messages.service_offer.update')]
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

        if ($this->serviceOffer->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'service_offer_id' => $this->serviceOfferService->destroy($id),
                ],
                'messages' => [__('messages.service_offer.destroy')]
            ]);
        }
    }
}
