<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Jobs\NotificationUser;
use Illuminate\Support\Facades\Log;

class CronJobController extends Controller
{
    public function index()
    {
        dispatch(new NotificationUser());
    }

    
}
