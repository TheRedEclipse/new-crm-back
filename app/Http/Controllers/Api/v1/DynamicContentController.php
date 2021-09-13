<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ImageHelper;
use App\Http\Requests\Api\v1\DynamicContentController\LoadImageRequest;
use App\Models\Attachment;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class DynamicContentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'permission:image.load'])->only(['loadImage']);
    }


    /**
     * Загрузка изображения
     *
     * @return \Illuminate\Http\Response
     */
    public function loadImage(LoadImageRequest $request, $type = null)
    {
        if($type) {
            return response()->json([
                'success' => true,
                'file' => ImageHelper::load($request->image, '/storage/uploads/images/attachments/')
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => ImageHelper::load($request->image, '/storage/uploads/images/attachments/')
        ]);
    }

    /**
     * Ресайз изображения
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeImage(Request $request, $id)
    {
        $attachment = Attachment::findOrFail($id);

        $image = Image::make(($attachment->url[0] === '/' ? 'https:' : '') . $attachment->url);
        $initHeight = $image->height();
        $initWidth = $image->width();
        if(!($request->width === null && $request->height === null)) {
            $image = $image->fit($request->width, $request->height, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            });
        }

        $mime = $attachment->path ? File::mimeType($attachment->path) : 'image/jpeg';
        $response = Response::make($image->encode($mime, 100), 200);
        $response->header("Content-Type", $mime);

        return $response;
    }
}
