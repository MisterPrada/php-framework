<?php

namespace App\Controllers;

use Core\Lib\FileSystem\Storage;

class StorageController extends Controller
{
    public function index(){

        var_dump( Storage::disk('app/public/')->get('info.txt') );

        var_dump( Storage::get('package.json') );

        //return Storage::connector();
    }
}