<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        try {
            $img = $request->upload;
            $imageLink = "";
            $imageUrl = UploadHelper::doUploadS3($img);
            if ($imageUrl) {
                $imageLink = UploadHelper::getUrlImage($imageUrl);
            }

            return response()->json([
                'fileName' => explode("/", $imageUrl)[1],
                'uploaded' => 1,
                'url' => $imageLink,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ]);
        }
    }
}
