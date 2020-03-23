<?php

namespace App\Admin\Controllers;

use App\Province;
use App\SmsDiffusion;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SmsDiffusionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\SmsDiffusion';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SmsDiffusion());
        $grid->column('status', __('Status'));
        $grid->column('content_fr', __('Content fr'));
        $grid->column('provinces', __('Zone cibles'))->display(function ($provinces) {
            $provinces = array_map(function ($role) {
                return "<span class='label label-success'>{$role['name']}</span>";
            }, $provinces);
            return join(',', $provinces);
        });
        $grid->column('date_diffusion', __('Date diffusion'));
        $grid->column('created_at', __('Date création'));
        $grid->column('updated_at', __('Date de mise à jour'));

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
        //TODO: Check user role here

        $show = new Show(SmsDiffusion::findOrFail($id));

        $show->field('status', __('Status'));
        $show->field('content_fr', __('Content fr'));
        $show->field('content_li', __('Content li'));
        $show->field('content_sw', __('Content sw'));
        $show->field('content_ts', __('Content ts'));
        $show->field('content_ki', __('Content ki'));
        $show->field('date_diffusion', __('Date diffusion'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SmsDiffusion());

        $form->select('status', __('Status'))->options(["DRAFT" => "Draft", "VALIDATED" => "Validé"]);
        $form->textarea('content_fr', __('Content (FR)'));
        $form->textarea('content_li', __('Content (Lingala)'));
        $form->textarea('content_sw', __('Content (Swahili)'));
        $form->textarea('content_ts', __('Content (Tshiluba)'));
        $form->textarea('content_ki', __('Content (Kikongo)'));
        $form->multipleSelect('provinces', __('Zones cibles'))->options(Province::all()->pluck('name', 'id'));
        $form->datetime('date_diffusion', __('Date diffusion'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
