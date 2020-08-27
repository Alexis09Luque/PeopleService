<?php

namespace App\Http\AuxiliarClasses;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ImageClass{

    public function uploadImage($request,$disk,$folder){
        $urlPhotoName = time().$request->file('photo')->getClientOriginalName();
        Storage::disk($disk)->put($urlPhotoName,File::get($request->file('photo')));
        $urlPhotoName = url("/").$folder.time().$request->file('photo')->getClientOriginalName();

        return $urlPhotoName;
    }

    public function deleteImage($people,$disk){
        $array = explode("/",$people->photo);
        $image_to_delete = $array[(count($array)-1)];
        $band = Storage::disk($disk)->delete($image_to_delete);
        return $band ;
    }
}