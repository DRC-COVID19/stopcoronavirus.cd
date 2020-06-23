<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;


class DashBoardController extends Controller
{
    public function index()
    {
        return view('diagnosticMaps.dashboard');
    }
}
