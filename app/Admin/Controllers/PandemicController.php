<?php

namespace App\Admin\Controllers;

use App\HealthZone;
use App\Pandemic;
use App\Province;
use App\Township;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PandemicController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Pandemic';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pandemic());
        $grid->column('province_id', __('Province'))->display(function ($province_id) {
            $province = Province::find($province_id);
            return $province->name;
        });
        $grid->column('confirmed', __('Confirmés'));
        $grid->column('sick', __('Malades'));
        $grid->column('seriously', __('Grave'));
        $grid->column('healed', __('Guéris'));
        $grid->column('dead', __('Décès'));
        $grid->column('last_update', __('Dernière modification'));
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
        $show = new Show(Pandemic::findOrFail($id));
        $show->field('province_id', __('Province'))->display(function ($province_id) {
            $province = Province::find($province_id);
            return $province->name;
        });
        $show->field('confirmed', __('Confirmés'));
        $show->field('sick', __('Malades'));
        $show->field('seriously', __('Grave'));
        $show->field('healed', __('Guéris'));
        $show->field('dead', __('Décès'));
        $show->field('created_at', __('Created at'));
        $show->field('last_update', __('Dernière modification'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Pandemic());
        $form->number('confirmed', __('Confirmés'))->default(0);
        $form->number('sick', __('Malades'));
        $form->number('seriously', __('Grave'));
        $form->number('healed', __('Guéris'));
        $form->number('dead', __('Décès'));
        $form->select('health_zone_id', __('Zone de santé'))->options(HealthZone::pluck('name', 'id'))->rules(['required']);
        $form->datetime('last_update', __('Dernière modification'))->rules(['required']);
        
        return $form;
    }
}
