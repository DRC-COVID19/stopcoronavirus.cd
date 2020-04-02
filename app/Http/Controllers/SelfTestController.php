<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SelfTestController extends Controller
{
    public function seltTest(Request $request)
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
        $content = $questions[0];

        $step = $request->session()->get('test.param');
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
                $request->session()->remove('test');
                $content = $questions[0];
                break;
        }
        $backId = $content['id'] - 1;
        $backUrl = route('selfTest.back', ['step' => $backId]);
        return view('selft_test', compact('content', 'backUrl'));
    }

    public function storeSelfTest( Request $request)
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
                $request->session()->put('test.2', $value);
                $request->session()->flash('test.param', 'step-3');
                return redirect()->route('selfTest.get');
            case '3':
                $request->session()->put('test.3', $value);
                $request->session()->flash('test.param', 'step-4');
                return redirect()->route('selfTest.get');
            case '4':
                $request->session()->put('test.4', $value);
                $request->session()->flash('test.param', 'step-5');
                return redirect()->route('selfTest.get');
            case '5':
                $request->session()->put('test.5', $value);
                $request->session()->flash('test.param', 'step-6');
                return redirect()->route('selfTest.get');
            case '6':
                $request->session()->put('test.6', $value);
                $request->session()->flash('test.param', 'step-7');
                return redirect()->route('selfTest.get');
            case '7':
                $request->session()->put('test.7', $value);
                if ($value == 0) {
                    $request->session()->flash('test.param', 'step-9');
                    return redirect()->route('selfTest.get');
                }
                $request->session()->flash('test.param', 'step-8');
                return redirect()->route('selfTest.get');
            case '8':
                $request->session()->put('test.8', $value);
                $request->session()->flash('test.param', 'step-9');
                return redirect()->route('selfTest.get');
            case '9':
                $request->session()->put('test.9', $value);
                $request->session()->flash('test.param', 'step-10');
                return redirect()->route('selfTest.get');
            case '10':
                $request->session()->put('test.10', $value);
                $request->session()->flash('test.param', 'step-11');
                return redirect()->route('selfTest.get');
            case '11':
                $request->session()->put('test.11', $value);
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
                $request->session()->put('test.12', $value);
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
                $request->session()->put('test.13', $value);
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
                $request->session()->put('test.14', $value);
                $request->session()->flash('test.param', 'step-15');
                return redirect()->route('selfTest.get');
            case '15':
                $request->session()->put('test.15', $value);
                $request->session()->flash('test.param', 'step-16');
                return redirect()->route('selfTest.get');
            case '16':
                $request->session()->put('test.16', $value);
                $request->session()->flash('test.param', 'step-17');
                return redirect()->route('selfTest.get');
            case '17':
                $request->session()->put('test.17', $value);
                $request->session()->flash('test.param', 'step-18');
                return redirect()->route('selfTest.get');
            case '18':
                $request->session()->put('test.18', $value);
                $request->session()->flash('test.param', 'step-19');
                return redirect()->route('selfTest.get');
            case '19':
                $request->session()->put('test.19', $value);
                $request->session()->flash('test.param', 'step-20');
                return redirect()->route('selfTest.get');
            case '20':
                $request->session()->put('test.20', $value);
                $request->session()->flash('test.param', 'step-21');
                return redirect()->route('selfTest.get');
            case '21':
                $request->session()->put('test.21', $value);
                $request->session()->flash('test.param', 'step-22');
                return redirect()->route('selfTest.get');
            case '22':
                $request->session()->put('test.22', $value);
                $request->session()->flash('test.param', 'step-23');
                return redirect()->route('selfTest.get');
            case '23':
                $request->session()->put('test.23', $value);
                $resultat = $this->result(request()->session()->get('test'));
                return view('selft_test_result', compact('resultat'));
                break;
            case '1':
            default:
                $request->session()->put('test.1', $value);
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
        if ($responses[1] == 1 && $responses[3] == 1) {
            if ($this->majorGravity() >= 1) {
                $message = "Appel 15.";
                return $message;
            } else {
                if ($this->hasPronostic()) {
                    if ($this->minorGravity() >= 2) {
                        $message = "appel 15";
                        return $message;
                    }
                    if (($this->majorGravity() == 0 && $this->minorGravity() == 1) || $this->majorGravity() == 0) {
                        $message = "téléconsultation ou médecin généraliste ou visite à domicile";
                        return $message;
                    }
                } else {
                    if ($this->majorGravity() == 0 && $this->minorGravity() <= 1) {
                        $message = "téléconsultation ou médecin généraliste ou visite à domicile (SOS médecins…)";
                        return $message;
                    }
                }
            }
        }
        if ($responses[1] == 1 || ($responses[3] == 1 && $responses[5] == 1) || ($responses[1] == 1  && $responses[6] == 1)) {
            if ($this->majorGravity() >= 2) {
                $message = "Appel 15";
                return $message;
            }
            if ($this->hasPronostic()) {
                if ($this->minorGravity() >= 2) {
                    $message = "Appel 15";
                    return $message;
                }
                if (($this->majorGravity() == 0 && $this->minorGravity() == 1) || $this->majorGravity() == 0) {
                    $message = "Téléconsultation ou médecin généraliste ou visite à domicile";
                    return $message;;
                }
            } else {
                if ($this->majorGravity() == 0 && $this->minorGravity() == 0 &&  $responses[12] < 50) {
                    $message = "Nous vous conseillons de rester à votre domicile et
                    de contacter votre médecin en cas d’apparition de nouveaux symptômes. Vous pourrez
                    aussi utiliser à nouveau l’application pour réévaluer vos symptômes";
                    return $message;
                }
                if ($this->majorGravity() == 0 && $this->minorGravity() >= 1 && $responses[12] >= 50 && $responses[12] <= 69) {
                    $message = "Téléconsultation ou médecin généraliste ou visite à domicile (SOS médecins…)";
                    return $message;
                }
            }
        }
        if ($responses[1] == 1 || $responses[3] == 1 || $responses[5] == 1) {
            if ($this->majorGravity() == 0 && $this->minorGravity() == 0) {
                $message = "Votre situation ne relève probablement pas du Covid-19. Consultez votre
                médecin au moindre doute.";
                return $message;
            }
            if (($this->majorGravity() > 0 || $this->minorGravity() > 0) && $this->hasPronostic()) {
                $message = "Votre situation ne relève probablement pas du Covid-19. Un avis médical est
                recommandé. Au moindre doute, appelez le 15.";
                return $message;
            }
        }
        $message = "Votre situation ne relève probablement pas du Covid-19. N’hésitez pas à contacter votre
        médecin en cas de doute. Vous pouvez refaire le test en cas de nouveau symptôme pour
        réévaluer la situation.";
        return $message;
    }

    public function hasPronostic()
    {
        $responses = request()->session()->get('test');
        $imc = $responses[14] / (($responses[13] / 100) ^ 2);
        if (
            $responses[12] >= 70 ||
            $imc >= 30 ||
            $responses[15] == 1 || $responses[16] == 1 ||
            $responses[17] == 1 || $responses[18] == 1 ||
            $responses[19] == 1 || $responses[20] == 1 ||
            $responses[21] == 1 || $responses[22] == 1 ||
            $responses[23] == 1
        ) {
            return true;
        }
        return false;
    }

    public function minorGravity()
    {
        $responses = request()->session()->get('test');
        if ((isset($responses[2]) && $responses[2] >= 39) && (isset($responses[8]) && $responses[8] == 1) && ($responses[10] == 3 || $responses[10] == 4)) {
            return 3;
        } else if ((isset($responses[2]) && $responses[2] >= 39) && (isset($responses[8]) && $responses[8] == 1)) {
            return 2;
        } else if ((isset($responses[2]) && $responses[2] >= 39) && ($responses[10] == 3 || $responses[10] == 4)) {
            return 2;
        } else if ((isset($responses[8]) && $responses[8] == 1) && ($responses[10] == 3 || $responses[10] == 4)) {
            return 2;
        } else if ($responses[10] == 3 || $responses[10] == 4) {
            return 1;
        } else if ((isset($responses[2]) && $responses[2] >= 39)) {
            return 1;
        } else if ((isset($responses[8]) && $responses[8] == 1)) {
            return 1;
        }
        return 0;
    }

    public function majorGravity()
    {
        $responses = request()->session()->get('test');
        if ((isset($responses[2]) && $responses[2] <= 34.4) && $responses[9] == 1 && $responses[11] == 1) {
            return 3;
        } else if ((isset($responses[2]) && $responses[2] <= 34.4) && $responses[9] == 1) {
            return 2;
        } else if ((isset($responses[2]) && $responses[2] <= 34.4) && $responses[11] == 1) {
            return 2;
        } else if ($responses[9] == 1 && $responses[11] == 1) {
            return 2;
        } else if ((isset($responses[2]) && $responses[2] <= 34.4)) {
            return 1;
        } else if ($responses[9] == 1) {
            return 1;
        } else if ($responses[11] == 1) {
            return 1;
        }
        return 0;
    }

    public function back($step, Request $request)
    {
        if ($step==0) {
           $step=1;
        }
        $request->session()->pull('test.{$step}');
        $request->session()->flash('test.param', "step-{$step}");
        return redirect()->route('selfTest.get');
    }
}
