<?php

namespace App\Services;

use App\Models\ProductImage;
use Intervention\Image\Facades\Image;

class UploadService
{
    private string $pathUploadCk = 'uploads/ckeditor/';
    private string $pathUploadImages = 'uploads/';

    public function uploadCkeditor($request)
    {
        if($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . $file->getClientOriginalName();
            $saveLocation = $this->pathUploadCk . $fileName;
            Image::make($file)->save($saveLocation);
            $url = asset('uploads/ckeditor/'. $fileName);
            $ckeditorFuncNum = $request->input('CKEditorFuncNum');

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($ckeditorFuncNum, '$url')</script>";
            @header('Content-type: text/html; charset=utf-8');

            return $response;
        }
    }

    public function uploadMultipleImage($request)
    {
        $arrPath = [];
        $images = $request->images;
        if($images) {
            foreach($images as $image) {
                $imageName = time() . $image->getClientOriginalName();
                $saveLocation = $this->pathUploadImages . $imageName;
                Image::make($image)->save($saveLocation);
                $arrPath[] = $imageName;
            }
        }

        return $arrPath;
    }
}
