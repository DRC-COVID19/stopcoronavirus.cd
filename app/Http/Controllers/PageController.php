<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
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
        $preventativeMeasures =PostResource::collection(Post::where('category_id', 1)->orderBy('order')->limit(3)->get())->toArray(request());
        $directives =PostResource::collection( Post::where('category_id', 2)->orderBy('order')->limit(1)->get())->toArray(request());
        
        return view('index', compact('alerts', 'preventativeMeasures', 'pandemicStats', 'directives'));
    }


    public function officialMeasure()
    {
        $officialMeasures =PostResource::collection(Post::where('category_id', 2)->orderBy('order')->get())->toArray(request());
        return view('official_measure', compact('officialMeasures'));
    }

    public function preventativeMeasures()
    {
        $category =Category::find(1);
        $preventativeMeasures =PostResource::collection( $category->articles()->orderBy('order')->limit(12)->get())->toArray(request());
        $category=CategoryResource::make($category)->toArray(request());
        return view('preventative_measures', compact('category', 'preventativeMeasures'));
    }


    public function stereotypes()
    {
        $stereotypes =PostResource::collection(Post::where('category_id', 3)->get())->toArray(request());
        return view('stereotypes', compact('stereotypes'));
    }

    public function changeLang()
    {
        $lang=request('lang');
        if (in_array($lang, ['fr', 'ln', 'kg','sw','ts'])) {
            session(['locale' => $lang]);
        }
        return back();
    }

    public function sondage()
    {
        return view('sondage');
    }

    public function aboutCmr(){
        return view('about_cmr');
    }
}
