<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $alerts = Alert::orderBy('created_at', 'desc')->limit(5)->get();
        $preventativeMeasures = Post::where('category_id', 1)->orderBy('order')->orderBy('title')->limit(6)->get();
        return view('index', compact('alerts', 'preventativeMeasures'));
    }


    public function officialMeasure()
    {
        $officialMeasures = Post::where('category_id', 2)->orderBy('order')->orderBy('title')->get();
        return view('official_measure', compact('officialMeasures'));
    }

    public function preventativeMeasures()
    {
        $preventativeMeasures = Post::where('category_id', 1)->orderBy('order')->orderBy('title')->limit(12)->get();
        return view('preventative_measures', compact('preventativeMeasures'));
    }


    public function stereotypes()
    {
        $stereotypes = Post::where('category_id', 3)->get();
        return view('stereotypes', compact('stereotypes'));
    }
}
