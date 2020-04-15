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
            $actions->disableView();
        });
        $grid->column('id', __('Id'));
        $grid->column('q-10', __('Age'))->filter('range');
        $grid->column('q-1', __('Fièvre'))->bool(
            [
                '1' => true,
                '2' => true,
                '3' => false,
                '4' => true,
                '5' => false
            ]
        )->filter([
            1 => 'Ne sais pas',
            2 => '39°C ou plus',
            3 => 'Entre 37,8°C et 38,9°C',
            4 => 'Moins de 35,5°C',
            5 => 'Pas de fièvre'
        ]);
        // $grid->column('q-2', __('Tempéranture'))->filter('range');
        $grid->column('q-2', __('Toux'))->bool();
        $grid->column('q-9', __('Soufle'))->bool(['1' => true, '0' => false])->filter([
            0 => 'Non',
            1 => 'oui',
        ]);
        $grid->column('q-4', __('Mal de gorge/courbatures'))->bool(['1' => true, '0' => false])->filter([
            0 => 'Non',
            1 => 'oui',
        ]);
        $grid->column('pronostique')->display(function () {
            $imc = $this['q-13'] / (($this['q-12'] / 100) ^ 2);
            if (
                $this['q-11'] >= 70 ||
                $imc >= 30 || $this['q-14'] == 1 ||
                $this['q-15'] == 1 || $this['q-16'] == 1 ||
                $this['q-17'] == 1 || $this['q-18'] == 1 ||
                $this['q-19'] == 1 || $this['q-20'] == 1 ||
                $this['q-21'] == 1 || $this['q-22'] == 1
            ) {
                return true;
            }
            return false;
        })->bool()->filter([
            false => 'Non',
            true => 'oui',
        ]);
        $grid->column('majeurs')->display(function () {
            if ($this['q-9'] == 1 && $this['q-11'] == 1) {
                return 2;
            } else if ($this['q-9'] == 1) {
                return 1;
            } else if ($this['q-11'] == 1) {
                return 1;
            }
            return 0;
        })->filter('range');

        $grid->column('mineurs')->display(function () {
            if ((isset($this['q-2']) && ($this['q-2'] >= 39 || $this['q-2'] < 35.5)) && (isset($this['q-8']) && $this['q-8'] == 1)) {
                return 2;
            } else if ($this['q-1']==2 || $this['q-1']==4) {
                return 1;
            } else if ((isset($this['q-8']) && $this['q-8'] == 1)) {
                return 1;
            }
            return 0;
        })->filter('range');

       // $grid->column('q-24', __('Région'))->filter('like');
        $grid->column('results_code', __('Results code'));
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
            });;
        $show->field('id', __('Id'));
        $show->field('q-1', __('Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?'));
        $show->field('q-2', __('Tempéranture'));
        $show->field('q-2', __('Toux'));
        $show->field('q-24', __('Région'));
        $show->field('results_code', __('Results code'));
        $show->field('results_message', __('Results message'));
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

        $form->number('q-1', __('Q 1'));
        $form->decimal('q-2', __('Q 2'));
        $form->number('q-3', __('Q 3'));
        $form->number('q-4', __('Q 4'));
        $form->number('q-5', __('Q 5'));
        $form->number('q-6', __('Q 6'));
        $form->number('q-7', __('Q 7'));
        $form->number('q-8', __('Q 8'));
        $form->number('q-9', __('Q 9'));
        $form->number('q-10', __('Q 10'));
        $form->number('q-11', __('Q 11'));
        $form->number('q-12', __('Q 12'));
        $form->number('q-13', __('Q 13'));
        $form->number('q-14', __('Q 14'));
        $form->number('q-15', __('Q 15'));
        $form->number('q-16', __('Q 16'));
        $form->number('q-17', __('Q 17'));
        $form->number('q-18', __('Q 18'));
        $form->number('q-19', __('Q 19'));
        $form->number('q-20', __('Q 20'));
        $form->number('q-21', __('Q 21'));
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
