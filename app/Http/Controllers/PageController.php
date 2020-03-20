<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('index');
    }


    public function officialMeasure()
    {
        return view('official_measure');
    }

    public function preventativeMeasures()
    {
        return view('preventative_measures');
    }


    public function stereotypes()
    {
        return view('stereotypes');
    }
}
