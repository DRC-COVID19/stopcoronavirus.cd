<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Alert\AlertForm;
use App\Admin\Forms\Alert\AlertFormFr;
use App\Admin\Forms\Alert\AlertFormKg;
use App\Admin\Forms\Alert\AlertFormLn;
use App\Admin\Forms\Alert\AlertFormSw;
use App\Admin\Forms\Alert\AlertFormTs;
use App\Alert;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\MultipleSteps;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\App;

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

        $grid->column('title', __('Title'))->display(function ()
        {
            $translate= $this->translates()->where('locale',App::getLocale())->first();
            if ($translate) {
                $translate->title;
            }
            return $this->translates()->first()->title;
        });
        $grid->column('content', __('Content'))->display(function ()
        {
            $translate= $this->translates()->where('locale',App::getLocale())->first();
            if ($translate) {
                $translate->content;
            }
            return $this->translates()->first()->content;
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
        $show = new Show(Alert::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->translates('translations',function ($translate)
        {
            $translate->locale();
            $translate->title();
            $translate->content();
            
          
        });
        return $show;
    }
    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        session()->remove('steps.alert_info');
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form());
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
        $category = Alert::find($id);
        if (!session()->get("steps.alert_info") ||session()->get("steps.alert_info")['id']!=$id ){
            $Fr = $category->translates()->where('locale', 'fr')->first()->toArray();
            $Kg = $category->translates()->where('locale', 'kg')->first()->toArray();
            $Ln = $category->translates()->where('locale', 'ln')->first()->toArray();
            $Sw = $category->translates()->where('locale', 'sw')->first()->toArray();
            $Ts = $category->translates()->where('locale', 'ts')->first()->toArray();
            session()->put("steps.alert_fr", $Fr);
            session()->put("steps.alert_kg", $Kg);
            session()->put("steps.alert_ln", $Ln);
            session()->put("steps.alert_sw", $Sw);
            session()->put("steps.alert_ts", $Ts);
            session()->put("steps.alert_info", $category->toArray());
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
        $steps = [
            'alert_fr' => AlertFormFr::class,
            'alert_kg' => AlertFormKg::class,
            'alert_ln' => AlertFormLn::class,
            'alert_sw' => AlertFormSw::class,
            'alert_ts' => AlertFormTs::class,
            'alert_info' => AlertForm::class
        ];
        return MultipleSteps::make($steps);
    }
}
