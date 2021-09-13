<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Social\IndexSocialRequest;
use App\Models\Social;
use App\Services\SocialService;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    protected $socialService;
    protected $social;

    public function __construct(SocialService $socialService, Social $social)
    {
        $this->socialService = $socialService;
        $this->social = $social;
    }

    public function index(IndexSocialRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'socials' => $this->socialService->all($request),
            ]
        ]);
    }
}
