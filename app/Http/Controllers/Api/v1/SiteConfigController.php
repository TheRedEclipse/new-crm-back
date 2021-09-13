<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SiteConfig\IndexSiteConfigRequest;
use App\Services\SiteConfigService;
use Illuminate\Http\Request;

class SiteConfigController extends Controller
{

    protected $siteConfigService;

    public function __construct(SiteConfigService $siteConfigService)
    {

        $this->siteConfigService = $siteConfigService;
    }


    public function index(IndexSiteConfigRequest $request)
    {

        return response()->json([

            'success' => true,
            'data' => [
                'config' => $this->siteConfigService->index($request),
            ],

        ]);
    }
}
