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

        $grid->column('label', __('Libelé'));
        $grid->column('value', __('Valeur'));
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

        $show->field('label', __('Libelé'));
        $show->field('value', __('Valeur'));
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

        $form->text('label', __('Libelé'));
        $form->number('value', __('Valeur'));
        $form->datetime('last_update', __('Dernière modification'));

        return $form;
    }
}
