<?php

namespace App\Admin\Forms\Category;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\StepForm;

class CatergoryTs extends StepForm
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
        //dump($request->all());
        return $this->next($request->all());
        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->html('Tshiluba', __('Language'));
        $this->hidden('locale')
        ->default("ts")->rules('required')
        ->value("ts");
        $this->hidden('id');
        $this->text('name', __('Name'))->required();
        $this->text('slug', __('Slug'));
        $this->summernote("description", __('Description'));
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
