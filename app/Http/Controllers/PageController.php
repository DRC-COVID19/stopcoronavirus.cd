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
    public function index()
    {
        $alerts = Alert::orderBy('created_at', 'desc')->limit(5)->get();
        $pandemicStats = DB::table('pandemic_stats')->selectRaw('SUM(confirmed) AS confirmed, SUM(sick) AS sick, SUM(seriously) AS seriously, SUM(healed) AS healed, SUM(dead) AS dead, SUM(imported) AS imported, SUM(local) AS local')->first();
        $last = DB::table('pandemic_stats')->latest()->first();
        $preventativeMeasures = Post::where('category_id', 1)->orderBy('order')->orderBy('title')->limit(6)->get();
        return view('index', compact('alerts', 'preventativeMeasures', 'pandemicStats','last'));
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
        $stereotypes = Post::where('category_id', 3)->get();
        return view('stereotypes', compact('stereotypes'));
    }
}
