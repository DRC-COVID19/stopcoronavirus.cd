<?php

namespace App\Http\Controllers;

use App\Diagnostic;
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
        'msg-1' =>
        [
            'text' => "Appelez le 101, 109 ou 110",
            'code' => "FIN5"
        ],
        'msg-2' => [
            'text' => "Votre situation peut relever d’un COVID 19.
            Demandez une consultation par téléphone à votre médecin généraliste ou à l'hôpital.
            Si vous n'arrivez pas à obtenir de consultation, appelez le 101, 109 ou 110.
            ",
            'code' => "FIN4"
        ],
        'msg-3' => [
            'text' => "Votre situation peut relever d'un COVID 19.
            Demandez une consultation par téléphone à votre médecin généraliste ou à l'hôpital.
            ",
            'code' => "FIN6"
        ],
        'msg-4' => [
            'text' => "Votre situation peut relever d'un COVID 19.
            Demandez une consultation par téléphone à votre médecin généraliste ou à l'hôpital.
            Si vous avez des difficultés à respirer ou des difficultés à manger ou à boire pendant plus de 24 heures, appelez le 101, 109 ou 110.
            ",
            'code' => "FIN3"
        ],
        'msg-5' => [
            'text' => "Votre situation peut relever d’un COVID 19 qu’il faut surveiller.
            Si de nouveaux symptômes apparaissent, refaites le test ou consultez votre médecin où l’hôpital.
            Nous vous conseillons de rester chez vous.",
            'code' => "FIN2"
        ],
        'msg-6' => [
            'text' => "Votre situation peut relever d’un COVID 19. Un avis médical est recommandé.
            Au moindre doute, appelez le 101, 109 ou 110. Nous vous conseillons de rester à votre domicile.",
            'code' => "FIN7"
        ],
        'msg-7' => [
            'text' => "Votre situation ne relève probablement pas du Covid-19. 
            N'hésitez pas à contacter votre médecin ou l’hôpital en cas de doute.
             Vous pouvez refaire le test en cas de nouveau symptôme pour réévaluer la situation.",
            'code' => "FIN8"
        ],
        'msg-8' => [
            'text' => "Cette application n’est pas faite pour les personnes de moins de 15 ans. 
            Prenez contact avec votre médecin généraliste au moindre doute. 
            En cas d’urgence, appelez le 101, 109 ou 110.",
            'code' => "FIN1"
        ],
    ];
    private $questions = [
        [
            'id' => 1,
            'q' => "Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?",
            'r' => 10,
        ],
        [
            'id' => 2,
            'q' => "Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?",
            'r' => 1
        ],
        [
            'id' => 3,
            'q' => "Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?",
            'r' => 1

        ],
        [
            'id' => 4,
            'q' => "Ces derniers jours, avez-vous eu un mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles ?",
            'r' => 1,
        ],
        [
            'id' => 5,
            'q' => "Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles.",
            'r' => 1,
        ],
        [
            'id' => 6,
            'q' => "Ces derniers jours, avez-vous une fatigue inhabituelle ?",
            'r' => 1,
        ],
        [
            'id' => 7,
            'q' => "Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?",
            'r' => 1,

        ],
        [
            'id' => 8,
            'q' => "Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?",
            'r' => 1,
        ],
        [
            'id' => 9,
            'q' => "Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?",
            'r' => 1,
        ],
        [
            'id' => 10,
            'q' => "Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique.",
            'r' => 5,
            'r_lable' => 'ans'
        ],
        [
            'id' => 11,
            'q' => "Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.",
            'r' => 6,
            'r_lable' => 'cm'
        ],
        [
            'id' => 12,
            'q' => "Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.",
            'r' => 7,
            'r_label' => 'kg'
        ],
        [
            'id' => 13,
            'q' => "Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?",
            'r' => 2
        ],
        [
            'id' => 14,
            'q' => "Êtes-vous diabétique ?",
            'r' => 1
        ],
        [
            'id' => 15,
            'q' => "Avez-vous ou avez-vous eu un cancer ces trois dernières années ?",
            'r' => 1
        ],
        [
            'id' => 16,
            'q' => "Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?",
            'r' => 1
        ],
        [
            'id' => 17,
            'q' => "Avez-vous une insuffisance rénale chronique dialysée ?",
            'r' => 1
        ],
        [
            'id' => 18,
            'q' => "Avez-vous une maladie chronique du foie ?",
            'r' => 1
        ],
        [
            'id' => 19,
            'q' => "Êtes-vous enceinte ?",
            'r' => 8
        ],
        [
            'id' => 20,
            'q' => "Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?",
            'r' => 2
        ],
        [
            'id' => 21,
            'q' => "Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive).",
            'r' => 2
        ],
        [
            'id' => 22,
            'q' => "Aidez la riposte à réaliser un suivi épidémiologique en donnant votre province, ville, commune et quartier.",
            'r' => 9
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
            case 'step-1':
            default:
                $request->session()->remove('test');
                $content = $this->questions[0];
                break;
        }
        $backId = $content['id'] - 1;
        $backUrl = route('selfTest.back', ['step' => $backId]);
        $isResultat = 2;
        return view('covidTest.selft_test', compact('content', 'backUrl', 'isResultat'));
    }

    public function storeSelfTest(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-2', $value);
                $request->session()->flash('test.param', 'step-3');
                return redirect()->route('selfTest.get');
            case '3':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-3', $value);
                $request->session()->flash('test.param', 'step-4');
                return redirect()->route('selfTest.get');
            case '4':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-4', $value);
                $request->session()->flash('test.param', 'step-5');
                return redirect()->route('selfTest.get');
            case '5':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-5', $value);
                $request->session()->flash('test.param', 'step-6');
                return redirect()->route('selfTest.get');
            case '6':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-6', $value);
                if ($value == 0) {
                    $request->session()->flash('test.param', 'step-8');
                    return redirect()->route('selfTest.get');
                }
                $request->session()->flash('test.param', 'step-7');
                return redirect()->route('selfTest.get');
            case '7':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-7', $value);
                $request->session()->flash('test.param', 'step-8');
                return redirect()->route('selfTest.get');
            case '8':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-8', $value);
                $request->session()->flash('test.param', 'step-9');
                return redirect()->route('selfTest.get');
            case '9':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-9', $value);
                $request->session()->flash('test.param', 'step-10');
                return redirect()->route('selfTest.get');
            case '10':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required|numeric|min:1|max:120'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-10', $value);
                // Test si le sujet à moins de 15 ans
                if ($value < 15) {
                    $resultat = $this->message['msg-8']['text'];
                    $isResultat = true;
                    $this->storeDiagnostic(request()->session()->get('test'), $this->message['msg-2']);
                    return view('covidTest.selft_test_result', compact('resultat', 'isResultat'));
                }

                $request->session()->flash('test.param', 'step-11');
                return redirect()->route('selfTest.get');
            case '11':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required|numeric|min:80|max:250'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-11', $value);
                $request->session()->flash('test.param', 'step-12');
                return redirect()->route('selfTest.get');
            case '12':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required|numeric|min:20|max:250'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-12', $value);
                $request->session()->flash('test.param', 'step-13');
                return redirect()->route('selfTest.get');
            case '13':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);

                if ($value == "2") {
                    $value = 1;
                }
                $request->session()->put('test.q-13', $value);
                $request->session()->flash('test.param', 'step-14');
                return redirect()->route('selfTest.get');
            case '14':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-14', $value);
                $request->session()->flash('test.param', 'step-15');
                return redirect()->route('selfTest.get');
            case '15':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-15', $value);
                $request->session()->flash('test.param', 'step-16');
                return redirect()->route('selfTest.get');
            case '16':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-16', $value);
                $request->session()->flash('test.param', 'step-17');
                return redirect()->route('selfTest.get');
            case '17':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-17', $value);
                $request->session()->flash('test.param', 'step-18');
                return redirect()->route('selfTest.get');
            case '18':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-18', $value);
                $request->session()->flash('test.param', 'step-19');
                return redirect()->route('selfTest.get');
            case '19':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-19', $value);
                $request->session()->flash('test.param', 'step-20');
                return redirect()->route('selfTest.get');
            case '20':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-20', $value);
                $request->session()->flash('test.param', 'step-21');
                return redirect()->route('selfTest.get');
            case '21':
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-21', $value);
                $request->session()->flash('test.param', 'step-22');
                return redirect()->route('selfTest.get');
            case '22':
                $validator = Validator::make($request->all(), [
                    'province' => 'nullable',
                    'town' => 'required_with:province',
                    'other_town' => 'required_if:town,0',
                    'township' => 'required_if:town,Kinshasa',
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }

                $province = $request->get('province');
                $town = $request->get('town');
                $other_town = $request->get('other_town');
                $township = $request->get('township');

                $request->session()->put('test.province', $province);

                if ($town == "0") {
                    $town = $other_town;
                }
                $request->session()->put('test.town', $town);
                $request->session()->put('test.township', $township);
                //$request->session()->put('test.q-23', $value);
                $resultat = $this->result(request()->session()->get('test'));
                $isResultat = 3;
                return view('covidTest.selft_test_result', compact('resultat', 'isResultat'));
            case '1':
            default:
                $validator = Validator::make($request->all(), [
                    'step_value' => 'required|between:1,5'
                ]);
                if ($validator->fails()) {
                    $request->session()->flash('test.param', "step-{$step}");
                    return redirect()->route('selfTest.get')->withErrors($validator);
                }
                $request->session()->put('test.q-1', $value);
                $request->session()->flash('test.param', 'step-2');
                return redirect()->route('selfTest.get');
        }
    }

    public function diagnostic()
    {
        $isResultat = 1;
        return view('covidTest.self_test_welcome', compact('isResultat'));
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
        try {
            $message = "";

            /**
             * SI >= 1 facteurs de gravité majeurs
             */
            if ($this->majorGravity($responses) >= 1) {
                $message = $this->message['msg-1']['text'];
                /**
                 * Appelez le 101.
                 */
                $this->storeDiagnostic($responses, $this->message['msg-1']);
                return $message;
            }
            /**
             * SI fièvre ET toux
             */
            if ($this->hasFever($responses) == 1 && $responses['q-2'] == 1) {

                if ($this->hasPronostic($responses)) {
                    if ($this->minorGravity($responses) >= 2) {
                        $message = $this->message['msg-2']['text'];
                        /**
                         * Votre situation peut relever d’un COVID 19.
                         * Demandez une téléconsultation ou un médecin généraliste ou une visite à domicile.
                         * Si vous n'arrivez pas à obtenir de consultation, appelez le 15.
                         */
                        $this->storeDiagnostic($responses, $this->message['msg-2']);
                        return $message;
                    } else { // SI < 2 facteur de gravité mineur
                        $message = $this->message['msg-3']['text'];
                        /**
                         * Votre situation peut relever d’un COVID 19.
                         * Demandez une téléconsultation ou un médecin généraliste ou une visite à domicile (SOS médecins, etc.)
                         */
                        $this->storeDiagnostic($responses, $this->message['msg-3']);
                        return $message;
                    }
                } else { // SI 0 facteur pronostique
                    $message = $this->message['msg-3']['text'];
                    /**
                     * Votre situation peut relever d’un COVID 19. 
                     * Demandez une téléconsultation ou un médecin généraliste ou une visite à domicile (SOS médecins, etc.)
                     */
                    $this->storeDiagnostic($responses, $this->message['msg-3']);
                    return $message;
                }
            }
            /**
             * SI fièvre OU (pas de fièvre et (diarrhée OU (toux ET douleurs) OU (toux ET anosmie))
             */
            if (
                $this->hasFever($responses) ||  // fievre
                ($responses['q-6'] == 1 ||  // diarrhée
                    ($responses['q-2'] == 1 && $responses['q-4'] == 1) // toux et douleurs
                    || ($responses['q-2'] == 1  && $responses['q-3'] == 1))
            ) { // toux et anosmie

                if ($this->hasPronostic($responses)) {
                    if ($this->minorGravity($responses) >= 2) {
                        $message = $this->message['msg-2']['text'];/*Votre situation peut relever d’un COVID 19.
                        Demandez une téléconsultation ou un médecin généraliste ou une visite à domicile.
                        Si vous n'arrivez pas à obtenir de consultation, appelez le 15.*/
                        $this->storeDiagnostic($responses, $this->message['msg-2']);
                        return $message;
                    }
                    if ($this->minorGravity($responses) <= 1) {
                        $message = $this->message['msg-4']['text'];
                        /*Votre situation peut relever d’un COVID 19.
                        Demandez une téléconsultation ou un médecin généraliste ou une visite à domicile.
                        Appelez le 15 si une gêne respiratoire ou des difficultés importantes pour vous alimenter ou boire apparaissent pendant plus de 24 heures. */
                        $this->storeDiagnostic($responses, $this->message['msg-4']);
                        return $message;;
                    }
                } else {

                    if ($this->minorGravity($responses) == 0) {
                        if ($responses['q-10'] < 50) {
                            $message = $this->message['msg-5']['text'];
                            /*Votre situation peut relever d’un COVID 19 qu’il faut surveiller. 
                            Si de nouveaux symptômes apparaissent, refaites le test ou consultez votre médecin.
                            Nous vous conseillons de rester à votre domicile.
                            */
                            $this->storeDiagnostic($responses, $this->message['msg-5']);
                            return $message;
                        } else {
                            $message = $this->message['msg-4']['text'];
                            /*Votre situation peut relever d’un COVID 19.
                            Demandez une téléconsultation ou un médecin généraliste ou une visite à domicile.
                            Appelez le 15 si une gêne respiratoire ou des difficultés importantes pour vous alimenter ou boire apparaissent pendant plus de 24 heures.
                         */
                            $this->storeDiagnostic($responses, $this->message['msg-4']);
                            return $message;
                        }
                    }
                    if ($this->minorGravity($responses) >= 1) {
                        $message = $this->message['msg-4']['text'];
                        /*
                        Votre situation peut relever d’un COVID 19.
                        Demandez une téléconsultation ou un médecin généraliste ou une visite à domicile.
                        Appelez le 15 si une gêne respiratoire ou des difficultés importantes pour vous alimenter ou boire apparaissent pendant plus de 24 heures.
                         */
                        $this->storeDiagnostic($responses, $this->message['msg-4']);
                        return $message;
                    }
                }
            }
            /**
             *  SI toux OU douleurs OU anosmie
             */
            if ($responses['q-2'] == 1 || $responses['q-4'] == 1 || $responses['q-3'] == 1) {
                if ($this->hasPronostic($responses)) {
                    $message = $this->message['msg-6']['text'];
                    /*
                    Votre situation peut relever d’un COVID 19. Un avis médical est recommandé.
                    Au moindre doute, appelez le 15. Nous vous conseillons de rester à votre domicile.
                     */
                    $this->storeDiagnostic($responses, $this->message['msg-6']);
                    return $message;
                } else {
                    $message = $this->message['msg-5']['text'];
                    /*
                    Votre situation peut relever d’un COVID 19 qu’il faut surveiller.
                    Si de nouveaux symptômes apparaissent, refaites le test ou consultez votre médecin.
                    Nous vous conseillons de rester à votre domicile.
                     */
                    $this->storeDiagnostic($responses, $this->message['msg-5']);
                    return $message;
                }
            }

            $message = $this->message['msg-7']['text'];
            /**
             * Votre situation ne relève probablement pas du COVID 19.
             * N’hésitez pas à contacter votre médecin en cas de doute.
             * Vous pouvez refaire le test en cas de nouveau symptôme pour réévaluer la situation.
             * Pour toute information concernant le COVID 19, composer le 0 800 130 000.
             */
            $this->storeDiagnostic($responses, $this->message['msg-7']);
            return $message;
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    /**
     *  1 => 'Ne sais pas'= Oui,
     *  2 => '39°C ou plus',
     *  3 => 'Entre 37,8°C et 38,9°C',
     *  4 => 'Moins de 35,5°C',
     *  5 => 'Pas de fièvre'
     */
    public function hasFever(array $responses)
    {
        if ($responses['q-1'] == 1 || $responses['q-1'] == 2 || $responses['q-1'] == 4) {
            return true;
        }
        return false;
    }
    /**
     * Facteur pronostique défavorable lié au terrain
     *OUI si l’âge est supérieur ou égal à 70 ans
     *OUI si l’indice de masse corporelle est supérieur ou égal à 30 kg/m²
     *Si OUI ou Je ne sais pas à la question sur l’hypertension artérielle
     *Si OUI pour “diabétique”
     *Si OUI pour “a ou a eu un cancer dans les trois dernières années”
     *Si OUI pour “maladie respiratoire ou suivi pneumologique”
     *Si OUI pour “insuffisance rénale”
     *Si OUI pour “maladie chronique du foie”
     *Si OUI pour “enceinte” (Non applicable : NON)
     *Si OUI pour maladie qui diminue les défenses immunitaires (Je ne sais pas : NON)
     *Si OUI pour traitement immunosuppresseur (Je ne sais pas : NON)
     */
    public function hasPronostic(array $responses)
    {
        $imc = $responses['q-12'] / (($responses['q-11'] / 100) ^ 2);
        if (
            $responses['q-10'] >= 70 ||
            $imc >= 30 || $responses['q-13'] == 1 ||
            $responses['q-14'] == 1 ||
            $responses['q-15'] == 1 || $responses['q-16'] == 1 ||
            $responses['q-17'] == 1 || $responses['q-18'] == 1 ||
            $responses['q-19'] == 1 || $responses['q-20'] == 1 ||
            $responses['q-21'] == 1
        ) {
            return true;
        }
        return false;
    }

    /**
     * Facteurs de gravité mineurs et majeurs
     *  1 => 'Ne sais pas'= Oui,
     *  2 => '39°C ou plus',
     *  3 => 'Entre 37,8°C et 38,9°C',
     *  4 => 'Moins de 35,5°C',
     *  5 => 'Pas de fièvre'
     *Fatigue : alitement > 50% du temps diurne

     */
    public function minorGravity(array $responses)
    {
        $r = 0;
        if ($responses['q-1'] == 1 || $responses['q-1'] == 2 || $responses['q-2'] == 4) {
            $r++;
        }
        if ((isset($responses['q-7']) && $responses['q-7'] == 1)) {
            $r++;
        }
        return $r;
    }

    /**
     * Facteurs de gravité majeurs
     *Gêne respiratoire
     *Difficultés importantes pour s’alimenter ou boire depuis plus de 24 heures

     */
    public function majorGravity(array $responses)
    {
        $r = 0;
        if ($responses['q-8'] == 1)
            $r++;
        if ($responses['q-9'] == 1)
            $r++;
        return $r;
    }

    public function storeDiagnostic(array $responses, array $message)
    {
        $responses['results_code'] = $message['code'];
        $responses['results_message'] = $message['text'];
        Diagnostic::create($responses);
    }

    public function back($step, Request $request)
    {
        if ($step == 0) {
            return redirect()->route('diagnostic');
        }
        $request->session()->pull('test.{$step}');
        $request->session()->flash('test.param', "step-{$step}");
        return redirect()->route('selfTest.get');
    }

    /**
     * Test diagnostic covid-19
     * @bodyParam q-1 int required between:1,5 Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?
     * @bodyParam q-2 int required between:0,1 Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?
     * @bodyParam q-3 int required between:0,1 Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?
     * @bodyParam q-4 int required between:0,1 Ces derniers jours, avez-vous eu un mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles ?
     * @bodyParam q-5 int required between:0,1 Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles"
     * @bodyParam q-6 int required between:0,1 Ces derniers jours, avez-vous une fatigue inhabituelle ?"
     * @bodyParam q-7 int required between:0,1 Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?
     * @bodyParam q-8 int required between:0,1 Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?
     * @bodyParam q-9 int required between:0,1 Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?
     * @bodyParam q-10 int required Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique.
     * @bodyParam q-11 int required Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
     * @bodyParam q-12 int required between:20,250 Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
     * @bodyParam q-13 int required Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?
     * @bodyParam q-14 int required Êtes-vous diabétique ?
     * @bodyParam q-15 int required Avez-vous ou avez-vous eu un cancer ces trois dernières années ?
     * @bodyParam q-16 int required Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?
     * @bodyParam q-17 int required Avez-vous une insuffisance rénale chronique dialysée ?
     * @bodyParam q-18 int required Avez-vous une maladie chronique du foie ?
     * @bodyParam q-19 int required Êtes-vous enceinte ?
     * @bodyParam q-20 int required Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?
     * @bodyParam q-21 int required Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive)
     * @bodyParam province string Quel est votre Province ? Cette information nous permet de réaliser un suivi épidémiologique.
     * @bodyParam town string Quel est votre ville ? Cette information nous permet de réaliser un suivi épidémiologique.
     * @bodyParam township string Quel est votre commune  ? Cette information nous permet de réaliser un suivi épidémiologique.
     * @bodyParam longitude longitude, Cette information nous permet de réaliser un suivi épidémiologique.
     * @bodyParam latitude latitude, Cette information nous permet de réaliser un suivi épidémiologique.
     */
    public function apiCovidTest(Request $request)
    {
        $data = Validator::make($request->all(), [
            'q-1' => 'required|numeric|between:1,5',
            'q-2' => 'sometimes|numeric|between:0,1',
            'q-3' => 'required|numeric|between:0,1',
            'q-4' => 'required|numeric|between:0,1',
            'q-5' => 'required|numeric|between:0,1',
            'q-6' => 'required|numeric|between:0,1',
            'q-7' => 'required_if:q-6,1|numeric|between:0,1',
            'q-8' => 'required|numeric|between:0,1',
            'q-9' => 'required|numeric|between:0,1',
            'q-10' => 'required|numeric|between:1,120',
            'q-11' => 'required|numeric|between:80,250',
            'q-12' => 'required|numeric|between:20,250',
            'q-13' => 'required|numeric|between:0,1',
            'q-14' => 'required|numeric|between:0,1',
            'q-15' => 'required|numeric|between:0,1',
            'q-16' => 'required|numeric|between:0,1',
            'q-17' => 'required|numeric|between:0,1',
            'q-18' => 'required|numeric|between:0,1',
            'q-19' => 'required|numeric|between:0,1',
            'q-20' => 'required|numeric|between:0,1',
            'q-21' => 'required|numeric|between:0,1',
            'province' => 'nullable',
            'town' => 'required_with:province',
            'other_town' => 'required_if:town,0',
            'township' => 'required_if:town,Kinshasa',
            'latitude' => 'string|nullable',
            'longitude' => 'string|nullable'
        ])->validate();
        try {
            if ($data["q-10"] < 15) {
                $resultat = $this->message['msg-8'];
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
