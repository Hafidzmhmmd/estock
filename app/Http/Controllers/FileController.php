<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;


class FileController extends Controller
{
    public function getfile($folder, $filename){
        $exists = Storage::disk('local')->exists("$folder/$filename");
        if($exists){
            $file = Storage::disk('local')->get("$folder/$filename");
            return (new Response($file))->header('Content-Type', mime_content_type(Storage::disk('local')->path("$folder/$filename")));
        }
    }
}
