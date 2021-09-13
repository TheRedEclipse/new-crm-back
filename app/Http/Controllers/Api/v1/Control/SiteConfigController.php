<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SiteConfig\IndexSiteConfigRequest;
use App\Http\Requests\Api\v1\SiteConfig\StoreSiteConfigRequest;
use App\Services\SiteConfigService;
use Illuminate\Http\Request;

class SiteConfigController extends Controller
{

    protected $siteConfigService;

    public function __construct(SiteConfigService $siteConfigService)
    {

        $this->siteConfigService = $siteConfigService;
        //$this->middleware(['auth:api', 'permission:admin.advantage.index'])->only(['index', 'all']);
        //$this->middleware(['auth:api', 'permission:admin.advantage.store'])->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexSiteConfigRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'config' => $this->siteConfigService->index($request),
            ],

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
    public function store(StoreSiteConfigRequest $request)
    {

        $this->siteConfigService->store($request);

        return response()->json([

            'success' => true,
            'messages' => [__('messages.config.store')]

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
        //
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
    public function update($request, $id)
    {
      //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
