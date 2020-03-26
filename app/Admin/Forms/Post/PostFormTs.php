<?php

namespace App\Admin\Forms\Post;

use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\StepForm;
use Illuminate\Http\Request;

class PostFormTs extends StepForm
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '';

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
        $this->text('title', __('Title'));
        $this->text('slug', __('Slug'));
        $this->summernote('content', __('Content'));
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
