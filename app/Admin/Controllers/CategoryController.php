<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Category\CategoryForm;
use App\Admin\Forms\Category\CatergoryFr;
use App\Admin\Forms\Category\CatergoryKg;
use App\Admin\Forms\Category\CatergoryLn;
use App\Admin\Forms\Category\CatergorySw;
use App\Admin\Forms\Category\CatergoryTs;
use App\Category;
use App\CategoryTranslation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\MultipleSteps;
use Illuminate\Support\Facades\App;

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
        $grid->column('name', __('Name'))->display(function ()
        {
            $translate= $this->translates()->where('locale',App::getLocale())->first();
            if ($translate) {
                $translate->name;
            }
            return $this->translates()->first()->name;
        });
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
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {

        $category = Category::find($id);
        $Fr = $category->translates()->where('locale', 'FR')->first()->toArray();
        $Kg = $category->translates()->where('locale', 'KG')->first()->toArray();
        $Ln = $category->translates()->where('locale', 'LN')->first()->toArray();
        $Sw = $category->translates()->where('locale', 'SW')->first()->toArray();
        $Ts = $category->translates()->where('locale', 'TS')->first()->toArray();

        session()->put("steps.Français", $Fr);
        session()->put("steps.Kikongo", $Kg);
        session()->put("steps.Lingala", $Ln);
        session()->put("steps.Swahili", $Sw);
        session()->put("steps.Tshiluba", $Ts);
        session()->put("steps.Info. général", $category->toArray());

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
        $steps = [
            'Français' => CatergoryFr::class,
            'Kikongo' => CatergoryKg::class,
            'Lingala' => CatergoryLn::class,
            'Swahili' => CatergorySw::class,
            'Tshiluba' => CatergoryTs::class,
            'Info. général' => CategoryForm::class
        ];
        return MultipleSteps::make($steps);
    }
}
