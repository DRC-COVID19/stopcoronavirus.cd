<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\CatergoryFr;
use App\Admin\Forms\CatergoryKg;
use App\Admin\Forms\CatergoryLn;
use App\Admin\Forms\CatergorySw;
use App\Admin\Forms\CatergoryTs;
use App\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\MultipleSteps;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gestion des catégories';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('name', __('Name'));
        $grid->column('updated_at', __('Updated at'));
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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('icon', __('Icon'));
        $show->field('slug', __('Slug'));
        $show->field('description', __('Description'));
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
        $steps = [
            'Français' => CatergoryFr::class,
            'Kikongo' => CatergoryKg::class,
            'Lingala' => CatergoryLn::class,
            'Swahili' => CatergorySw::class,
            'Tshiluba' => CatergoryTs::class
        ];
        /* $category = new Category();
        $form = new Form($category);
        $form->text('icon', __('Icon'));
        $form->hasMany('translates', function (Form\NestedForm $form) {
            $form->select('locale', __('Language'))->options(["FR" => "Français", "KG" => "Kikongo", "LN" => "Lingala", "TS" => "Tshiluba", "SW" => "Swahili"])->default("FR")->required();
            $form->text('name', __('Name'))->required();
            $form->text('slug', __('Slug'));
            $unique = uniqid();
            $form->summernote("description{$unique}", __('Description'));
        })->required();*/
        return Tab::forms($steps);
    }
}
