<?php

namespace App\Admin\Controllers;

use App\Administrator;
use App\Hospital;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Builder;


class HospitalController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Hospital';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Hospital());
        $grid->column('name', "Nom");
        $grid->column('address', "Adresse");
        $grid->column('respirators', "respirateurs");
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
        $show = new Show(Hospital::findOrFail($id));
        $show->field('name', __('Nom'));
        $show->field('address', 'Adresse');
        $show->field('respirators', __('Total respirateurs'));
        $show->field('latitude', __('Latitude'));
        $show->field('longitude', __('Longitude'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Hospital());
        $form->text('name', __('Nom'))->rules(['required']);
        $form->textarea('address', 'Adresse')->rules(['required']);
        $form->number('foam_beds', __('Total Lits avec mouse'))->rules(['required']);
        $form->number('resuscitation_beds', __('Total Lits de réanimation'))->rules(['required']);
        $form->number('respirators', __('Total respirateurs'))->default(0);
        $form->number('doctors', __('Nombre medecins'))->rules(['required']);
        $form->number('nurses', __('Nombre Infirmiers'))->rules(['required']);
        $form->number('para_medicals', __('Nombre para-medicals'))->rules(['required']);
        $form->select('agent_id', __('Agent'))->options(function () {
            return Administrator::whereHas('roles', function (Builder $query) {
                $query->where('name', 'agent-hospital');
            })->pluck('username', 'id');
        })->rules(['required']);
        // $form->latlong('latitude', 'longitude', 'Position')->height(500);

        return $form;
    }
}
