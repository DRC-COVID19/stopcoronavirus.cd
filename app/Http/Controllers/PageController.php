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

    public function seltTest($step=null, Request $request)
    {
        $questions = [
            [
                'id' => 1,
                'q' => "Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?",
                'q2' => "Quelle a été votre température la plus élevée de ces dernières 48 heures ?",
                'r' => [1, 2]
            ],
            [
                'id' => 2,
                'q' => "Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?",
            ],
            [
                'id' => 3,
                'q' => "Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?"
            ],
            [
                'id' => 4,
                'q' => "Ces derniers jours, avez-vous eu un mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles ?"
            ],
            [
                'id' => 5,
                'q' => "Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles."
            ],
            [
                'id' => 6,
                'q' => "Ces derniers jours, avez-vous une fatigue inhabituelle ?",
                'q2' => "Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?"
            ],
            [
                'id' => 7,
                'q' => "Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?"
            ],
            [
                'id' => 8,
                'q' => "Comment vous sentez-vous ?"
            ],
            [
                'id' => 9,
                'q' => "Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?"
            ],
            [
                'id' => 10,
                'q' => "Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique."
            ],
            [
                'id' => 11,
                'q' => "Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection."
            ],
            [
                'id' => 12,
                'q' => "Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection."
            ],
            [
                'id' => 13,
                'q' => "Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?"
            ],
            [
                'id' => 14,
                'q' => "Êtes-vous diabétique ?",
            ],
            [
                'id' => 15,
                'q' => "Avez-vous ou avez-vous eu un cancer ces trois dernières années ?",
            ],
            [
                'id' => 16,
                'q' => "Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?"
            ],
            [
                'id' => 17,
                'q' => "Avez-vous une insuffisance rénale chronique dialysée ?",
            ],
            [
                'id' => 18,
                'q' => "Avez-vous une maladie chronique du foie ?"
            ],
            [
                'id' => 19,
                'q' => "Êtes-vous enceinte ?"
            ],
            [
                'id' => 20,
                'q' => "Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?"
            ],
            [
                'id' => 21,
                'q' => "Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive)."
            ]
        ];
        $content = $questions[0];

        switch ($step) {
            case '':
                # code...
                break;

            default:
            $content=$questions[0];
                break;
        }
        return view('selft_test',compact('content'));
    }
}
