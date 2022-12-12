<?php

namespace MSA\LaravelGrapes\Http\Controllers;

use Illuminate\Http\Request;
use MSA\LaravelGrapes\Http\Controllers\Controller;

class FrontendController extends Controller
{


    public function Demo() 
    {
       return view('lg::demo');
    }

}