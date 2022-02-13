<?php

namespace App\Controllers\Admin;

class MainController extends Controller
{
    public function index()
    {
        require_once __PUBLIC__ . 'admin-panel/index.html';
    }
}