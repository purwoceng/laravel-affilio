<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        return view('content.configs.index');
    }
}
