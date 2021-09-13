<?php

namespace App\Http\Helpers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ImageHelper {
  public static function load($image, $route, $handle = 'webp', $name = null, $max_size = 1920)
  {
    $image= Image::make($image);

    if($max_size !== null) {
      if($image->width() > $max_size){
        $image = $image->resize($max_size, null, function ($constraint) {
          $constraint->aspectRatio();
        });
      }
    }

    if($handle == 'all') {
        $image = (string) $image->encode('jpg', 75);
        $extention = 'jpg';
    } if($handle == 'webp') {
        $image = (string) $image->encode('webp', 90);
        $extention = 'webp';
    } elseif ($handle == 'png') {
        $image = (string) $image->encode('png', 90);
        $extention = 'png';
    }

    
    $image_name= ($name ?? time()).'.'.$extention;
    if(!File::isDirectory(public_path().$route)) {
      File::makeDirectory(public_path().$route, 0777, true);
    }
    $path = public_path().($route ?? '/storage/uploads/images/').$image_name;

    file_put_contents($path, $image);

    return [
      'url' => '//api.modernciti.group' . ($route ?? '/storage/uploads/images/') . $image_name,
      'path' => $path,
    ];
  }

  public static function resize($url, $width = null, $height = null) {
    $image = Image::make($url);
    if($width === null && $height === null) return $image;
    
    $image = $image->resize($width, $height, function ($constraint) {
      $constraint->aspectRatio();
    });

    return $image;
  }
}