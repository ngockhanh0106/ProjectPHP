<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class UploadMultipleImage extends Controller
{
    protected UploadService $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function store(Request $request)
    {
        try {
            $arrPathImage = $this->uploadService->uploadMultipleImage($request);
            return response()->json([
                'images' => $arrPathImage,
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }
}
