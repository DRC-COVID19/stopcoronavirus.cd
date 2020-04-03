<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group User management
 *
 * APIs for managing users
 */
class SelfTestController extends Controller
{
    private $message = [
        'msg-1' => "Prenez contact avec votre médecin généraliste au moindre
        doute. Cette application n’est pour l’instant pas adaptée aux personnes de moins
        de 15 ans. En cas d’urgence, appeler le 15.",
        'msg-2' => "Appel 15.",
        'msg-3' => "Téléconsultation ou médecin généraliste ou visite à domicile",
        'msg-4' => "Téléconsultation ou médecin généraliste ou visite à domicile (SOS médecins…)",
        'msg-5' => "Nous vous conseillons de rester à votre domicile et
        de contacter votre médecin en cas d’apparition de nouveaux symptômes. Vous pourrez
        aussi utiliser à nouveau l’application pour réévaluer vos symptômes",
        'msg-6' => "Votre situation ne relève probablement pas du Covid-19. Consultez votre
        médecin au moindre doute.",
        'msg-7' => "Votre situation ne relève probablement pas du Covid-19. Un avis médical est
        recommandé. Au moindre doute, appelez le 15",
        'msg-8' => "Votre situation ne relève probablement pas du Covid-19. N’hésitez pas à contacter votre
        médecin en cas de doute. Vous pouvez refaire le test en cas de nouveau symptôme pour
        réévaluer la situation."
    ];
    private $questions = [
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
            'r_lable' => 'ans'
        ],
        [
            'id' => 13,
            'q' => "Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.",
            'r' => 6,
            'r_lable' => 'cm'
        ],
        [
            'id' => 14,
            'q' => "Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.",
            'r' => 7,
            'r_label' => 'kg'
        ],
        [
            'id' => 15,
            'q' => "Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?",
            'r' => 2
        ],
        [
            'id' => 16,
            'q' => "Êtes-vous diabétique ?",
            'r' => 1
        ],
        [
            'id' => 17,
            'q' => "Avez-vous ou avez-vous eu un cancer ces trois dernières années ?",
            'r' => 1
        ],
        [
            'id' => 18,
            'q' => "Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?",
            'r' => 1
        ],
        [
            'id' => 19,
            'q' => "Avez-vous une insuffisance rénale chronique dialysée ?",
            'r' => 1
        ],
        [
            'id' => 20,
            'q' => "Avez-vous une maladie chronique du foie ?",
            'r' => 1
        ],
        [
            'id' => 21,
            'q' => "Êtes-vous enceinte ?",
            'r' => 8
        ],
        [
            'id' => 22,
            'q' => "Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?",
            'r' => 2
        ],
        [
            'id' => 23,
            'q' => "Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive).",
            'r' => 2
        ]
    ];
    public function seltTest(Request $request)
    {
        $content = $this->questions[0];
        $step = $request->session()->get('test.param');
        switch ($step) {
            case 'step-2':
                $content = $this->questions[1];
                break;
            case 'step-3':
                $content = $this->questions[2];
                break;
            case 'step-4':
                $content = $this->questions[3];
                break;
            case 'step-5':
                $content = $this->questions[4];
                break;
            case 'step-6':
                $content = $this->questions[5];
                break;
            case 'step-7':
                $content = $this->questions[6];
                break;
            case 'step-8':
                $content = $this->questions[7];
                break;
            case 'step-9':
                $content = $this->questions[8];
                break;
            case 'step-10':
                $content = $this->questions[9];
                break;
            case 'step-11':
                $content = $this->questions[10];
                break;
            case 'step-12':
                $content = $this->questions[11];
                break;
            case 'step-13':
                $content = $this->questions[12];
                break;
            case 'step-14':
                $content = $this->questions[13];
                break;
            case 'step-15':
                $content = $this->questions[14];
                break;
            case 'step-16':
                $content = $this->questions[15];
                break;
            case 'step-17':
                $content = $this->questions[16];
                break;
            case 'step-18':
                $content = $this->questions[17];
                break;
            case 'step-19':
                $content = $this->questions[18];
                break;
            case 'step-20':
                $content = $this->questions[19];
                break;
            case 'step-21':
                $content = $this->questions[20];
                break;
            case 'step-22':
                $content = $this->questions[21];
                break;
            case 'step-23':
                $content = $this->questions[22];
                break;
            case 'step-1':
            default:
                $request->session()->remove('test');
                $content = $this->questions[0];
                break;
        }
        $backId = $content['id'] - 1;
        $backUrl = route('selfTest.back', ['step' => $backId]);
        $isResultat = false;
        return view('covidTest.selft_test', compact('content', 'backUrl', 'isResultat'));
    }

    public function storeSelfTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'step_value' => 'required|numeric',
            'current_step' => 'required'
        ]);
        $value = $request->get('step_value');
        $step = $request->get('current_step');

        if ($validator->fails()) {
            $request->session()->flash('test.param', $step);
            return redirect()->route('selfTest.get')->withErrors($validator);
        }
        switch ($step) {
            case '2':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'numeric|min:34|max:42'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', $step);
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-2', $value);
                $request->session()->flash('test.param', 'step-3');
                return redirect()->route('selfTest.get');
            case '3':
                $request->session()->put('test.q-3', $value);
                $request->session()->flash('test.param', 'step-4');
                return redirect()->route('selfTest.get');
            case '4':
                $request->session()->put('test.q-4', $value);
                $request->session()->flash('test.param', 'step-5');
                return redirect()->route('selfTest.get');
            case '5':
                $request->session()->put('test.q-5', $value);
                $request->session()->flash('test.param', 'step-6');
                return redirect()->route('selfTest.get');
            case '6':
                $request->session()->put('test.q-6', $value);
                $request->session()->flash('test.param', 'step-7');
                return redirect()->route('selfTest.get');
            case '7':
                $request->session()->put('test.q-7', $value);
                if ($value == 0) {
                    $request->session()->flash('test.param', 'step-9');
                    return redirect()->route('selfTest.get');
                }
                $request->session()->flash('test.param', 'step-8');
                return redirect()->route('selfTest.get');
            case '8':
                $request->session()->put('test.q-8', $value);
                $request->session()->flash('test.param', 'step-9');
                return redirect()->route('selfTest.get');
            case '9':
                $request->session()->put('test.q-9', $value);
                $request->session()->flash('test.param', 'step-10');
                return redirect()->route('selfTest.get');
            case '10':
                $request->session()->put('test.q-10', $value);
                $request->session()->flash('test.param', 'step-11');
                return redirect()->route('selfTest.get');
            case '11':
                $request->session()->put('test.q-11', $value);
                $request->session()->flash('test.param', 'step-12');
                return redirect()->route('selfTest.get');
            case '12':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'numeric|min:1|max:120'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', $step);
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                if ($value < 15) {
                    $resultat = $this->message['msg-1'];
                    $isResultat = true;
                    return view('covidTest.selft_test_result', compact('resultat', 'isResultat'));
                }

                $request->session()->put('test.q-12', $value);
                $request->session()->flash('test.param', 'step-13');
                return redirect()->route('selfTest.get');
            case '13':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'numeric|min:80|max:250'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', $step);
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-13', $value);
                $request->session()->flash('test.param', 'step-14');
                return redirect()->route('selfTest.get');
            case '14':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'numeric|min:20|max:250'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', $step);
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-14', $value);
                $request->session()->flash('test.param', 'step-15');
                return redirect()->route('selfTest.get');
            case '15':
                $request->session()->put('test.q-15', $value);
                $request->session()->flash('test.param', 'step-16');
                return redirect()->route('selfTest.get');
            case '16':
                $request->session()->put('test.q-16', $value);
                $request->session()->flash('test.param', 'step-17');
                return redirect()->route('selfTest.get');
            case '17':
                $request->session()->put('test.q-17', $value);
                $request->session()->flash('test.param', 'step-18');
                return redirect()->route('selfTest.get');
            case '18':
                $request->session()->put('test.q-18', $value);
                $request->session()->flash('test.param', 'step-19');
                return redirect()->route('selfTest.get');
            case '19':
                $request->session()->put('test.q-19', $value);
                $request->session()->flash('test.param', 'step-20');
                return redirect()->route('selfTest.get');
            case '20':
                $request->session()->put('test.q-20', $value);
                $request->session()->flash('test.param', 'step-21');
                return redirect()->route('selfTest.get');
            case '21':
                $request->session()->put('test.q-21', $value);
                $request->session()->flash('test.param', 'step-22');
                return redirect()->route('selfTest.get');
            case '22':
                $request->session()->put('test.q-22', $value);
                $request->session()->flash('test.param', 'step-23');
                return redirect()->route('selfTest.get');
            case '23':
                $request->session()->put('test.q-23', $value);
                $resultat = $this->result(request()->session()->get('test'));
                $isResultat = true;
                return view('covidTest.selft_test_result', compact('resultat', 'isResultat'));
                break;
            case '1':
            default:
                $request->session()->put('test.q-1', $value);
                if ($value == 0) {
                    $request->session()->flash('test.param', 'step-3');
                    return redirect()->route('selfTest.get');
                }
                $request->session()->flash('test.param', 'step-2');
                return redirect()->route('selfTest.get');
        }
    }

    public function redirectError($step, $validator)
    {
        if ($validator->fails()) {
            request()->session()->flash('test.param', $step);
            return redirect()->route('selfTest.get')->withErrors($validator);
        }
        return null;
    }

    public function result(array $responses)
    {

        $message = "";
        if ($responses['q-1'] == 1 && $responses['q-3'] == 1) {
            if ($this->majorGravity($responses) >= 1) {
                $message = $this->message['msg-2'];
                return $message;
            } else {
                if ($this->hasPronostic($responses)) {
                    if ($this->minorGravity($responses) >= 2) {
                        $message = $this->message['msg-2'];
                        return $message;
                    }
                    if (($this->majorGravity($responses) == 0 && $this->minorGravity($responses) == 1) || $this->majorGravity($responses) == 0) {
                        $message = $this->message['msg-3'];
                        return $message;
                    }
                } else {
                    if ($this->majorGravity($responses) == 0 && $this->minorGravity($responses) <= 1) {
                        $message = $this->message['msg-4'];
                        return $message;
                    }
                }
            }
        }
        if ($responses['q-1'] == 1 || ($responses['q-3'] == 1 && $responses['q-5'] == 1) || ($responses['q-1'] == 1  && $responses['q-6'] == 1)) {
            if ($this->majorGravity($responses) >= 2) {
                $message = $this->message['msg-2'];
                return $message;
            }
            if ($this->hasPronostic($responses)) {
                if ($this->minorGravity($responses) >= 2) {
                    $message = $this->message['msg-2'];
                    return $message;
                }
                if (($this->majorGravity($responses) == 0 && $this->minorGravity($responses) == 1) || $this->majorGravity($responses) == 0) {
                    $message = $this->message['msg-3'];
                    return $message;;
                }
            } else {
                if ($this->majorGravity($responses) == 0 && $this->minorGravity($responses) == 0 &&  $responses['q-12'] < 50) {
                    $message = $this->message['msg-5'];
                    return $message;
                }
                if ($this->majorGravity($responses) == 0 && $this->minorGravity($responses) >= 1 && $responses['q-12'] >= 50 && $responses['q-12'] <= 69) {
                    $message = $this->message['msg-4'];
                    return $message;
                }
            }
        }
        if ($responses['q-1'] == 1 || $responses['q-3'] == 1 || $responses['q-5'] == 1) {
            if ($this->majorGravity($responses) == 0 && $this->minorGravity($responses) == 0) {
                $message = $this->message['msg-6'];
                return $message;
            }
            if (($this->majorGravity($responses) > 0 || $this->minorGravity($responses) > 0) && $this->hasPronostic($responses)) {
                $message = $this->message['msg-7'];
                return $message;
            }
        }
        $message = $this->message['msg-8'];
        return $message;
    }

    public function hasPronostic(array $responses)
    {
        $imc = $responses['q-14'] / (($responses['q-13'] / 100) ^ 2);
        if (
            $responses['q-12'] >= 70 ||
            $imc >= 30 ||
            $responses['q-15'] == 1 || $responses['q-15'] == 2 || $responses['q-16'] == 1 ||
            $responses['q-17'] == 1 || $responses['q-18'] == 1 ||
            $responses['q-19'] == 1 || $responses['q-20'] == 1 ||
            $responses['q-21'] == 1 || $responses['q-22'] == 1 ||
            $responses['q-23'] == 1
        ) {
            return true;
        }
        return false;
    }

    public function minorGravity(array $responses)
    {
        if ((isset($responses['q-2']) && $responses['q-2'] >= 39) && (isset($responses['q-8']) && $responses['q-8'] == 1) && ($responses['q-10'] == 3 || $responses['q-10'] == 4)) {
            return 3;
        } else if ((isset($responses['q-2']) && $responses['q-2'] >= 39) && (isset($responses['q-8']) && $responses['q-8'] == 1)) {
            return 2;
        } else if ((isset($responses['q-2']) && $responses['q-2'] >= 39) && ($responses['q-10'] == 3 || $responses['q-10'] == 4)) {
            return 2;
        } else if ((isset($responses['q-8']) && $responses['q-8'] == 1) && ($responses['q-10'] == 3 || $responses['q-10'] == 4)) {
            return 2;
        } else if ($responses['q-10'] == 3 || $responses['q-10'] == 4) {
            return 1;
        } else if ((isset($responses['q-2']) && $responses['q-2'] >= 39)) {
            return 1;
        } else if ((isset($responses['q-8']) && $responses['q-8'] == 1)) {
            return 1;
        }
        return 0;
    }

    public function majorGravity(array $responses)
    {
        if ((isset($responses['q-2']) && $responses['q-2'] <= 34.4) && $responses['q-9'] == 1 && $responses['q-11'] == 1) {
            return 3;
        } else if ((isset($responses['q-2']) && $responses['q-2'] <= 34.4) && $responses['q-9'] == 1) {
            return 2;
        } else if ((isset($responses['q-2']) && $responses['q-2'] <= 34.4) && $responses['q-11'] == 1) {
            return 2;
        } else if ($responses['q-9'] == 1 && $responses['q-11'] == 1) {
            return 2;
        } else if ((isset($responses['q-2']) && $responses['q-2'] <= 34.4)) {
            return 1;
        } else if ($responses['q-9'] == 1) {
            return 1;
        } else if ($responses['q-11'] == 1) {
            return 1;
        }
        return 0;
    }

    public function back($step, Request $request)
    {
        if ($step == 0) {
            $step = 1;
        }
        $request->session()->pull('test.{$step}');
        $request->session()->flash('test.param', "step-{$step}");
        return redirect()->route('selfTest.get');
    }

    /**
     * Test diagnostique covid-19
     * @bodyParam q-1 int required Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?
     * @bodyParam q-2 int  Quelle a été votre température la plus élevée de ces dernières 48 heures ?
     * @bodyParam q-3 int required Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?
     * @bodyParam q-4 int required Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?
     * @bodyParam q-5 int required Ces derniers jours, avez-vous eu un mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles ?
     * @bodyParam q-6 int required Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles"
     * @bodyParam q-7 int required Ces derniers jours, avez-vous une fatigue inhabituelle ?"
     * @bodyParam q-8 int required Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?
     * @bodyParam q-9 int required Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?
     * @bodyParam q-10 int required Comment vous sentez-vous ?
     * @bodyParam q-11 int required Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?
     * @bodyParam q-12 int required Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique.
     * @bodyParam q-13 int required Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
     * @bodyParam q-14 int required Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
     * @bodyParam q-15 int required Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?
     * @bodyParam q-16 int required Êtes-vous diabétique ?
     * @bodyParam q-17 int required Avez-vous ou avez-vous eu un cancer ces trois dernières années ?
     * @bodyParam q-18 int required Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?
     * @bodyParam q-19 int required Avez-vous une insuffisance rénale chronique dialysée ?
     * @bodyParam q-20 int required Avez-vous une maladie chronique du foie ?
     * @bodyParam q-21 int required Êtes-vous enceinte ?
     * @bodyParam q-22 int required Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?
     * @bodyParam q-23 int required Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive)
     * 
     */
    public function apiCovidTest(Request $request)
    {
        $data = Validator::make($request->all(), [
            'q-1' => 'required|numeric|between:0,1',
            'q-2' => 'sometimes|numeric|between:34,42',
            'q-3' => 'required|numeric|between:0,1',
            'q-4' => 'required|numeric|between:0,1',
            'q-5' => 'required|numeric|between:0,1',
            'q-6' => 'required|numeric|between:0,1',
            'q-7' => 'required|numeric|between:0,1',
            'q-8' => 'required_if:q-7,1|numeric|between:0,1',
            'q-9' => 'required|numeric|between:0,1',
            'q-10' => 'required|numeric|between:1,4',
            'q-11' => 'required|numeric|between:0,1',
            'q-12' => 'required|numeric|between:1,120',
            'q-13' => 'required|numeric|between:80,250',
            'q-14' => 'required|numeric|between:20,250',
            'q-15' => 'required|numeric|between:0,1',
            'q-16' => 'required|numeric|between:0,1',
            'q-17' => 'required|numeric|between:0,1',
            'q-18' => 'required|numeric|between:0,1',
            'q-19' => 'required|numeric|between:0,1',
            'q-20' => 'required|numeric|between:0,1',
            'q-21' => 'required|numeric|between:0,1',
            'q-22' => 'required|numeric|between:0,1',
            'q-23' => 'required|numeric|between:0,1',
        ])->validate();
        try {
            if ($data["q-12"] < 15) {
                $resultat = $this->message['msg-1'];
                return response()->json(['resultat' => $resultat]);
            }
            $resultat = $this->result($data);
            return response()->json(['resultat' => $resultat]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
}
