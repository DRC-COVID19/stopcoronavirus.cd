<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gestion des contenus';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post());
        $grid->column('image_path', __('#'))->image('', 50, 50);
        $grid->column('order',__('Order'));
        $grid->column('title', __('Title'));
        $grid->column('category_id', __('Category'))->display(function ($category_id) {
            $category = Category::find($category_id);
            return $category->name;
        });
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
        $show = new Show(Post::findOrFail($id));

        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('order',__('Order'));
        $show->field('width',__('Width'));
        $show->field('slug', __('Slug'));
        $show->field('category_id', __('Category id'))->display(function ($category_id) {
            $category = Category::find($category_id);
            return $category->name;
        });
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
        $form = new Form(new Post());

        $form->text('title', __('Title'));
        $form->summernote('content', __('Content'));
        $form->number('order',__('Order'));
        $form->number('width',__('Width'))->default(4)->rules(['max:12|min:1|required']);
        $form->text('slug', __('Slug'));
        $form->image('image_path', __("Illustration image"));
        $form->select('category_id', __('Category'))->options(function () {
            return Category::pluck('name', 'id');
        });

        return $form;
    }
}
