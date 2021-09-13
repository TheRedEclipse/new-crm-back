<?php

namespace App\Http\Controllers\Api\v1\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Social\IndexSocialRequest;
use App\Http\Requests\Api\v1\Social\StoreSocialRequest;
use App\Http\Requests\Api\v1\Social\UpdateSocialRequest;
use App\Models\Social;
use App\Services\SocialService;

class SocialController extends Controller
{

    protected $socialService;
    protected $social;

    public function __construct(SocialService $socialService, Social $social)
    {

        $this->socialService = $socialService;
        $this->social = $social;

        $this->middleware(['auth:api', 'permission:admin.social.index'])->only(['index', 'all']);
        $this->middleware(['auth:api', 'permission:admin.social.edit'])->only(['edit']);
        $this->middleware(['auth:api', 'permission:admin.social.store'])->only(['store']);
        $this->middleware(['auth:api', 'permission:admin.social.update'])->only(['update']);
        $this->middleware(['auth:api', 'permission:admin.social.destroy.soft'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexSocialRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'socials' => $this->socialService->index($request),
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
                'socials' => $this->social->whereDeletedAt(null)->get(),
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
    public function store(StoresocialRequest $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'social_id' => $this->socialService->store($request),
            ],
            'messages' => [__('messages.social.store')]

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
        if ($this->social->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'contact-social' => $this->socialService->show($id),
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
    public function update(UpdatesocialRequest $request, $id)
    {
        if ($this->social->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'social_id' => $this->socialService->update($request, $id),
                ],
                'messages' => [__('messages.social.update')]
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
        if ($this->social->findOrFail($id)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'social_id' => $this->socialService->destroy($id),
                ],
                'messages' => [__('messages.social.destroy')]
            ]);
        }
    }
}
