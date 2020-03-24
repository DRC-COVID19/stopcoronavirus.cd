<?php

namespace App\Admin\Controllers;

use App\PandemicStat;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PandemicStatController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gestion de stats';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PandemicStat());

        $grid->column('confirmed', __('Confirmés'));
        $grid->column('local',__('Cas local'));
        $grid->column('imported',__('Cas importés'));
        $grid->column('sick',__('Malades'));
        $grid->column('seriously',__('Grave'));
        $grid->column('healed',__('Guéris'));
        $grid->column('dead',__('Morts'));
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
        $show = new Show(PandemicStat::findOrFail($id));

        $show->field('confirmed', __('Confirmés'));
        $show->field('local',__('Cas local'));
        $show->field('imported',__('Cas importés'));
        $show->field('sick',__('Malades'));
        $show->field('seriously',__('Grave'));
        $show->field('healed',__('Guéris'));
        $show->field('dead',__('Morts'));
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
        $form = new Form(new PandemicStat());

        $form->number('confirmed', __('Confirmés'))->default(0);
        $form->number('local',__('Cas local'));
        $form->number('imported',__('Cas importés'));
        $form->number('sick',__('Malades'));
        $form->number('seriously',__('Grave'));
        $form->number('healed',__('Guéris'));
        $form->number('dead',__('Morts'));
        $form->datetime('last_update', __('Dernière modification'))->rules(['required']);
        return $form;
    }
}
