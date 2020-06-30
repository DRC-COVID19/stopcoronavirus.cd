<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\PandemicForm;
use App\Admin\Forms\PandemicGenreForm;
use App\Hospital;
use App\HospitalSituation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\MultipleSteps;

class HospitalSituationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\HospitalSituation';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HospitalSituation());

        $grid->column('id', __('Id'));
        $grid->column('hospital_id', __('Hospital'))->display(function ($hospital_id) {
            $hospital = Hospital::find($hospital_id);
            return $hospital->name;
        });
        $grid->column('confirmed', __('Confirmed'));
        $grid->column('sick', __('Sick'));
        $grid->column('healed', __('Healed'));
        $grid->column('dead', __('Dead'));
        $grid->column('last_update', __('Last update'));

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
        $show = new Show(HospitalSituation::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('hospital_id', __('Hospital'))->as(function ($hospital_id) {
            $hospital = Hospital::find($hospital_id);
            return $hospital->name;
        });
        $show->field('confirmed', __('Confirmed'));
        $show->field('sick', __('Sick'));
        $show->field('healed', __('Healed'));
        $show->field('dead', __('Dead'));
        $show->field('last_update', __('Last update'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    public function form()
    {
        $forms = [
            'basic'    => PandemicForm::class,
            'genre'    => PandemicGenreForm::class,
        ];
        return MultipleSteps::make($forms);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    // protected function form()
    // {
    //     $form = new Form(new HospitalSituation());
    //     $form->divider(__('Informations sur la pandémie'));
    //     $form->select('hospital_id', __('Hospital'))->options(function () {
    //         return Hospital::pluck('name', 'id');
    //     })->rules('required');
    //     $form->number('confirmed', __('Confirmés'))->default(0);
    //     $form->number('sick', __('malades'))->default(0);
    //     $form->number('healed', __('guéris'))->default(0);
    //     $form->number('dead', __('décès'))->default(0);

    //     $form->divider(__('Informations sur la pandémie par genre'));
    //     $form->html('html contents');
    //     $form->number('confirmed', __('Confirmed'))->default(0);
    //     $form->number('sick', __('Sick'))->default(0);
    //     $form->number('healed', __('Healed'))->default(0);
    //     $form->number('dead', __('Dead'))->default(0);
    //     $form->divider(__('Informations sur la pandémie par genre'));
    //     $form->html('html contents');
    //     $form->number('confirmed', __('Confirmed'))->default(0);
    //     $form->number('sick', __('Sick'))->default(0);
    //     $form->number('healed', __('Healed'))->default(0);
    //     $form->number('dead', __('Dead'))->default(0);
    //     $form->datetime('last_update', __('Last update'))->default(date('Y-m-d H:i:s'));

    //     return $form;
    // }
}
