<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Category;
use App\PandemicStat;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * home
     */
    public function index()
    {
        $alerts = Alert::orderBy('created_at', 'desc')->limit(5)->get();
        $pandemicStats = PandemicStat::orderBy('last_update', 'DESC')->first();
        $preventativeMeasures = Post::where('category_id', 1)->orderBy('order')->orderBy('title')->limit(3)->get();
        $directives = Post::where('category_id', 2)->orderBy('order')->orderBy('title')->limit(1)->get();
        return view('index', compact('alerts', 'preventativeMeasures', 'pandemicStats', 'directives'));
    }


    public function officialMeasure()
    {
        $officialMeasures = Post::where('category_id', 2)->orderBy('order')->orderBy('title')->get();
        return view('official_measure', compact('officialMeasures'));
    }

    public function preventativeMeasures()
    {
        $category = Category::find(1);
        $preventativeMeasures = $category->articles()->orderBy('order')->limit(12)->get();
        return view('preventative_measures', compact('category', 'preventativeMeasures'));
    }


    public function stereotypes()
    {
        $stereotypes = Post::where('category_id', 3)->orderBy('order')->get();
        return view('stereotypes', compact('stereotypes'));
    }
}
