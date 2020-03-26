<?php

namespace App\Admin\Forms\Post;

use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\StepForm;
use Illuminate\Http\Request;

class PostFormFr extends StepForm
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
        $this->html('Francais', __('Language'));
        $this->hidden('locale')
        ->default("fr")
        ->value("fr");
        $this->hidden('id');
        $this->text('title', __('Title'))->required()->rules('required');
        $this->text('slug', __('Slug'));
        $this->summernote('content', __('Content'))->required()->rules('required');
       
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
