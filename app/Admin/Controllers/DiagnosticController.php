<?php

namespace App\Admin\Controllers;

use App\Diagnostic;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DiagnosticController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Diagnostic';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Diagnostic());

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            // $actions->disableView();
        });
        $grid->column('id', __('Id'));
        $grid->column('age_range', __('Tranche âge'))->filter([
            'inf_15' => 'inf_15',
            'from_15_to_49' => 'from_15_to_49',
            'from_50_to_69' => 'from_50_to_69',
            'sup_70' => 'sup_70'
        ]);
        $grid->column('temperature_cat', __('Fièvre'))->bool(
            [
                'NSP' => true,
                'sup_39' => true,
                '37.8-38.9' => false,
                'inf_35.5' => true,
                '35.5-37.7' => false
            ]
        )->filter([
            'NSP' => 'Ne sais pas',
            'sup_39' => '39°C ou plus',
            '37.8-38.9' => 'Entre 37,8°C et 38,9°C',
            'inf_35.5' => 'Moins de 35,5°C',
            '35.5-37.7' => 'Pas de fièvre'
        ]);
        // $grid->column('cough', __('Tempéranture'))->filter('range');
        $grid->column('cough', __('Toux'))->bool();
        $grid->column('breathlessness', __('Soufle'))->bool(['1' => true, '0' => false])->filter([
            0 => 'Non',
            1 => 'oui',
        ]);
        $grid->column('sore_throat_aches', __('Mal de gorge/courbatures'))->bool(['1' => true, '0' => false])->filter([
            0 => 'Non',
            1 => 'oui',
        ]);
        $grid->column('pronostique')->display(function () {
            if (
                $this['age_range']=='sup_70' ||
                $this['imc'] >= 30 || $this['heart_disease_algo'] == 1 ||
                $this['diabetes'] == 1 ||
                $this['cancer'] == 1 || $this['breathing_disease'] == 1 ||
                $this['kidney_disease'] == 1 || $this['liver_disease'] == 1 ||
                $this['pregnant'] == 1 || $this['immunosuppressant_disease_algo'] == 1 ||
                $this['immunosuppressant_drug_algo'] == 1
            ) {
                return true;
            }
            return false;
        })->bool()->filter([
            false => 'Non',
            true => 'oui',
        ]);
        $grid->column('majeurs')->display(function () {
            $r = 0;
            if ($this['feeding_day'] == 1)
                $r++;
            if ($this['breathlessness'] == 1)
                $r++;
            return $r;
        })->filter('range');

        $grid->column('mineurs')->display(function () {
            $r = 0;
            if ($this['fever_algo'] == true) {
                $r++;
            }
            if ($this['tiredness_details'] == 1) {
                $r++;
            }
            return $r;
        })->filter('range');

        // $grid->column('q-24', __('Région'))->filter('like');
        $grid->column('orientation', __('Orientation'));
        $grid->column('duration', __('Durée'));
        $grid->column('created_at', __('Created at'));
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Diagnostic::findOrFail($id));
        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableDelete();
            });

        $show->field('id', __('Id'));
        $show->{"temperature_cat"}(__('Fièvre ces 48 dernières heures (frissons, sueurs) ?'))->as(function ($value) {
            $r = "";
            switch ($value) {
                case "NSP":
                    $r = "Ne sais pas";
                    break;
                case "sup_39":
                    $r = "39°C ou plus";
                    break;
                case "37.8-38.9":
                    $r = "Entre 37,8°C et 38,9°C";
                    break;
                case 'inf_35.5':
                    $r = "Moins de 35,5°C";
                    break;
                case '35.5-37.7':
                    $r = "Pas de fièvre";
                    break;
            }
            return $r;
        });
        $show->field('cough', __('Augmentation de votre toux habituelle '));
        $show->field('agueusia_anosmia', __('Anosmie'));
        $show->field('sore_throat_aches', __('Mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles'));
        $show->field('diarrhea', __('Ces dernières 24 heures, avez-vous de la diarrhée'));
        $show->field('tiredness', __('Une fatigue inhabituelle'));
        $show->field('tiredness_details', __('Alitement > 50% du temps diurne'));
        $show->field('feeding_day', __('Impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS'));
        $show->field('breathlessness', __('Manque de souffle INHABITUEL'));
        $show->field('age_range', __('Quel est votre âge'));
        $show->field('heart_disease', __('hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?'));
        $show->field('diabetes', __('Êtes-vous diabétique ?'));
        $show->field('cancer', __('Avez-vous ou avez-vous eu un cancer ces trois dernières années ?'));
        $show->field('breathing_disease', __('Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?'));
        $show->field('kidney_disease', __('Avez-vous une insuffisance rénale chronique dialysée ?'));
        $show->field('liver_disease', __('Avez-vous une maladie chronique du foie ?'));
        $show->field('pregnant', __('Êtes-vous enceinte ?'));
        $show->field('immunosuppressant_disease', __('Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?'));
        $show->field('immunosuppressant_drug', __('Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive).'));
        $show->field('orientation', __('orientation'));
        $show->field('results_message', __('Results message'));
        $show->field('province', __('Province'));
        $show->field('town', __('Ville'));
        $show->field('township', __('Commune'));
        $show->field('duration', __('Durée'));
        $show->field('algo_version', __('algo_version'));
        $show->field('created_at', __('Created at'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Diagnostic());

        $form->number('fever_algo', __('Q 1'));
        $form->decimal('cough', __('Q 2'));
        $form->number('agueusia_anosmia', __('Q 3'));
        $form->number('sore_throat_aches', __('Q 4'));
        $form->number('diarrhea', __('Q 5'));
        $form->number('tiredness', __('Q 6'));
        $form->number('tiredness_details', __('Q 7'));
        $form->number('feeding_day', __('Q 8'));
        $form->number('breathlessness', __('Q 9'));
        $form->number('age_range', __('Q 10'));
        $form->number('size', __('Q 11'));
        $form->number('weight', __('Q 12'));
        $form->number('heart_disease', __('Q 13'));
        $form->number('diabetes', __('Q 14'));
        $form->number('cancer', __('Q 15'));
        $form->number('breathing_disease', __('Q 16'));
        $form->number('kidney_disease', __('Q 17'));
        $form->number('liver_disease', __('Q 18'));
        $form->number('pregnant', __('Q 19'));
        $form->number('immunosuppressant_disease', __('Q 20'));
        $form->number('immunosuppressant_drug', __('Q 21'));
        $form->number('q-22', __('Q 22'));
        $form->number('q-23', __('Q 23'));
        $form->text('q-24', __('Q 24'));
        $form->text('results_code', __('Results code'));
        $form->text('results_message', __('Results message'));
        $form->text('latitude', __('Latitude'));
        $form->text('longitude', __('Longitude'));

        return $form;
    }
}
