<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class showProfileImageController extends Controller
{
    public function showProfileImage($filename)
    {
        $path = storage_path('app/public/profile/' . $filename);


        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file)->header('Content-Type', $type);
    }
}
