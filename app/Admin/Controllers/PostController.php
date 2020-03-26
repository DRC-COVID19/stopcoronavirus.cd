<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Post\PostForm;
use App\Admin\Forms\Post\PostFormFr;
use App\Admin\Forms\Post\PostFormKg;
use App\Admin\Forms\Post\PostFormLn;
use App\Admin\Forms\Post\PostFormSw;
use App\Admin\Forms\Post\PostFormTs;
use App\Category;
use App\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\MultipleSteps;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\App;

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
        $grid->column('image_path', __('#'))->image(url('/storage'), 50, 50);
        $grid->column('order',__('Order'));
        $grid->column('title', __('Title'))->display(function ()
        {
            $translate= $this->translates()->where('locale',App::getLocale())->first();
            if ($translate) {
               return $translate->title;
            }
            return $this->translates()->first()->title;
        });
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
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $post=Post::find($id);
        if (!session()->get("steps.Info général") ||session()->get("steps.Info général")['id']!=$id ){
            $Fr = $post->translates()->where('locale', 'fr')->first()->toArray();
            $Kg = $post->translates()->where('locale', 'kg')->first()->toArray();
            $Ln = $post->translates()->where('locale', 'ln')->first()->toArray();
            $Sw = $post->translates()->where('locale', 'sw')->first()->toArray();
            $Ts = $post->translates()->where('locale', 'ts')->first()->toArray();

            session()->put("steps.Français", $Fr);
            session()->put("steps.Kikongo", $Kg);
            session()->put("steps.Lingala", $Ln);
            session()->put("steps.Swahili", $Sw);
            session()->put("steps.Tshiluba", $Ts);
            session()->put("steps.Info général", $post->toArray());
        }
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form());
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
       // session()->remove('steps');
        $steps = [
            'Français' => PostFormFr::class,
            'Kikongo' => PostFormKg::class,
            'Lingala' => PostFormLn::class,
            'Swahili' => PostFormSw::class,
            'Tshiluba' => PostFormTs::class,
            'Info général' => PostForm::class
        ];
        return MultipleSteps::make($steps);
    }
}
