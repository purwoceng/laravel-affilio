<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;

class ExceptionController extends Controller
{
    public function index()
    {
        // something went wrong and you want to throw CustomException
        throw new CustomException('Something Went Wrong.');
    }
}
