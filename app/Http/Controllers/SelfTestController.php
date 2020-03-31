<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SelfTestController extends Controller
{

    public function seltTest($step = null, Request $request)
    {
        $questions = [
            [
                'id' => 1,
                'q' => "Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?",
                'r' => 1,
            ],
            [
                'id' => 2,
                'q' => "Quelle a été votre température la plus élevée de ces dernières 48 heures ?",
                'r' => 3
            ],
            [
                'id' => 3,
                'q' => "Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?",
                'r' => 1
            ],
            [
                'id' => 4,
                'q' => "Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?",
                'r' => 1

            ],
            [
                'id' => 5,
                'q' => "Ces derniers jours, avez-vous eu un mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles ?",
                'r' => 1,
            ],
            [
                'id' => 6,
                'q' => "Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles.",
                'r' => 1,
            ],
            [
                'id' => 7,
                'q' => "Ces derniers jours, avez-vous une fatigue inhabituelle ?",
                'r' => 1,
            ],
            [
                'id' => 8,
                'q' => "Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?",
                'r' => 1,

            ],
            [
                'id' => 9,
                'q' => "Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?",
                'r' => 1,
            ],
            [
                'id' => 10,
                'q' => "Comment vous sentez-vous ?",
                'r' => 4,
            ],
            [
                'id' => 11,
                'q' => "Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?",
                'r' => 1,
            ],
            [
                'id' => 12,
                'q' => "Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique.",
                'r' => 5,
                'r_lable'=>'ans'
            ],
            [
                'id' => 13,
                'q' => "Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.",
                'r' => 6,
                'r_lable'=>'cm'
            ],
            [
                'id' => 14,
                'q' => "Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.",
                'r' => 7,
                'r_label'=>'kg'
            ],
            [
                'id' => 15,
                'q' => "Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?",
                'r'=> 2
            ],
            [
                'id' => 16,
                'q' => "Êtes-vous diabétique ?",
                'r'=> 1
            ],
            [
                'id' => 17,
                'q' => "Avez-vous ou avez-vous eu un cancer ces trois dernières années ?",
                'r'=> 1
            ],
            [
                'id' => 18,
                'q' => "Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?",
                'r'=> 1
            ],
            [
                'id' => 19,
                'q' => "Avez-vous une insuffisance rénale chronique dialysée ?",
                'r'=> 1
            ],
            [
                'id' => 20,
                'q' => "Avez-vous une maladie chronique du foie ?",
                'r'=> 1
            ],
            [
                'id' => 21,
                'q' => "Êtes-vous enceinte ?",
                'r'=> 8
            ],
            [
                'id' => 22,
                'q' => "Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?",
                'r'=> 2
            ],
            [
                'id' => 23,
                'q' => "Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive).",
                'r'=> 2
            ]
        ];
        $content = $questions[0];

        switch ($step) {
            case 'step-2':
                $content = $questions[1];
                break;
            case 'step-3':
                $content = $questions[2];
                break;
            case 'step-4':
                $content = $questions[3];
                break;
            case 'step-5':
                $content = $questions[4];
                break;
            case 'step-6':
                $content = $questions[5];
                break;
            case 'step-7':
                $content = $questions[6];
                break;
            case 'step-8':
                $content = $questions[7];
                break;
            case 'step-9':
                $content = $questions[8];
                break;
            case 'step-10':
                $content = $questions[9];
                break;
            case 'step-11':
                $content = $questions[10];
                break;
            case 'step-12':
                $content = $questions[11];
                break;
            case 'step-13':
                $content = $questions[12];
                break;
            case 'step-14':
                $content = $questions[13];
                break;
            case 'step-15':
                $content = $questions[14];
                break;
            case 'step-16':
                $content = $questions[15];
                break;
            case 'step-17':
                $content = $questions[16];
                break;
            case 'step-18':
                $content = $questions[17];
                break;
            case 'step-19':
                $content = $questions[18];
                break;
            case 'step-20':
                $content = $questions[19];
                break;
            case 'step-21':
                $content = $questions[20];
                break;
            case 'step-22':
                $content = $questions[21];
                break;
            case 'step-23':
                $content = $questions[22];
                break;
            case 'step-1':
            default:
                $content = $questions[0];
                break;
        }
        $backId = $content['id'] - 1;
        $backUrl = route('selfTest.get', ['step' => 'step-' . $backId]);
        return view('selft_test', compact('content', 'backUrl'));
    }

    public function storeSelfTest($step = null, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'step_value' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('selfTest.get', ['step' => $step])->withErrors($validator);
        }
        $value = $request->get('step_value');
        switch ($step) {
            case 'step-2':
                session('test.2', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-3']);
            case 'step-3':
                session('test.3', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-4']);
            case 'step-4':
                session('test.4', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-5']);
            case 'step-5':
                session('test.5', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-6']);
            case 'step-6':
                session('test.6', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-7']);
            case 'step-7':
                session('test.7', $value);
                if ($value == 0) {
                    return redirect()->route('selfTest.get', ['step' => 'step-9']);
                }
                return redirect()->route('selfTest.get', ['step' => 'step-8']);
            case 'step-8':
                session('test.8', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-9']);
            case 'step-9':
                session('test.9', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-10']);
            case 'step-10':
                session('test.10', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-11']);
            case 'step-11':
                session('test.11', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-12']);
            case 'step-12':
                session('test.12', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-13']);
            case 'step-13':
                session('test.13', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-14']);
            case 'step-14':
                session('test.14', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-15']);
            case 'step-15':
                session('test.15', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-16']);
            case 'step-16':
                session('test.16', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-17']);
            case 'step-17':
                session('test.17', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-18']);
            case 'step-18':
                session('test.18', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-19']);
            case 'step-19':
                session('test.19', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-20']);
            case 'step-20':
                session('test.20', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-21']);
            case 'step-21':
                session('test.21', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-22']);
            case 'step-22':
                session('test.22', $value);
                return redirect()->route('selfTest.get', ['step' => 'step-23']);
            case 'step-23':
                dump(session());
                exit;
            break;
            case 'step-1':
            default:
                session('test.1', $value);
                if ($value == 0) {
                    return redirect()->route('selfTest.get', ['step' => 'step-3']);
                }
                return redirect()->route('selfTest.get', ['step' => 'step-2']);
                break;
        }
    }

    public function back()
    {
        return back();
    }
}
