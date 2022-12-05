<?php

namespace App\Admin\Controllers;

use App\Alert;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AlertController extends AdminController
{
  /**
   * Title for current resource.
   *
   * @var string
   */
  protected $title = 'Gestion des alertes';

  /**
   * Make a grid builder.
   *
   * @return Grid
   */
  protected function grid()
  {
    $grid = new Grid(new Alert());

    $grid->column('title', __('Title'));
    $grid->column('content', __('Content'));
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
    $show = new Show(Alert::findOrFail($id));

    $show->field('id', __('Id'));
    $show->field('title', __('Title'));
    $show->field('content', __('Content'));
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
    $form = new Form(new Alert());

    $form->text('title', __('Title'));
    $form->textarea('content', __('Content'));

    return $form;
  }
}
