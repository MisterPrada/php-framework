<?php

namespace App\Controllers;

use Core\Lib\FileSystem\Storage;

class StorageController extends Controller
{
    public function index(){

        $file = Storage::disk('app/public')->getFile('info.txt');

        //Storage::disk('app/public/media')->putFile('test.txt', $file->content);

        //Storage::disk('app/public/')->removeFile('test.txt');

        var_dump( $file->dirPath );

        //return Storage::connector();
    }
}