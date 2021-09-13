<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ServiceOffer\IndexServiceOfferRequest;
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
                'service_offers' => $this->serviceOfferService->all($request),
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

        if ($this->serviceOffer->findOrFail($id)) {

            return response()->json([
                'success' => true,
                'data' => [
                    'service_offer' => $this->serviceOfferService->show($id),
                ]
            ]);
        }
    }
}
