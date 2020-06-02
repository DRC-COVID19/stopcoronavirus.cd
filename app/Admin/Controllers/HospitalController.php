<?php

namespace App\Admin\Controllers;

use App\Hospital;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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
        $grid->column('name',"Nom");
        $grid->column('address',"Adresse");
        $grid->column('Beds',"Total Lits");
        $grid->column('occupied_beds',"Lits occupés");
        $grid->column('respirators',"respirateurs");
        $grid->column('masks',"Masques");
        $grid->column('busy_respirators',__('Respirateurs occupés'));
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
        $show->field('name',__('Nom'));
        $show->field('address','Adresse');
        $show->field('beds',__('Total Lits'));
        $show->field('occupied_beds',__('Lits occupés'));
        $show->field('respirators',__('Total respirateurs'));
        $show->field('occupied_respirators',__('Respirateurs occupés'));
        $show->field('masks',__('Masque'));
        $show->field('latitude',__('Latitude'));
        $show->field('longitude',__('Longitude'));
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
        $form->text('name',__('Nom'))->rules(['required']);
        $form->textarea('address','Adresse')->rules(['required']);
        $form->number('beds',__('Total Lits'))->rules(['required']);
        $form->number('occupied_Beds',__('Lits occupés'))->default(0);
        $form->number('respirators',__('Total respirateurs'))->default(0);
        $form->number('occupied_respirators',__('Respirateurs occupés'))->default(0);
        $form->number('masks',__('Masque'))->default(0);
        $form->latlong('latitude', 'longitude', 'Position')->height(500);
        
        return $form;
    }
}
