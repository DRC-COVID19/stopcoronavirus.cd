<?php

namespace App\Admin\Forms\Alert;

use App\Alert;
use App\AlertTranslation;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\StepForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertFormTs extends StepForm
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Tshiluba';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
       return $this->next($request->all());
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->html('Tshiluba', __('Language'));
        $this->hidden('locale')
            ->default("ts")
            ->value("ts");
        $this->hidden('id');
        $this->text('title', __('Title'))->required()->rules('required_without:content');
        $this->textarea('content', __('Content'))->required()->rules('required_without:title');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
       return parent::data();
    }
}
