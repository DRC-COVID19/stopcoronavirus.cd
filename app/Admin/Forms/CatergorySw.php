<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\StepForm;

class CatergorySw extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Swahili';

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

        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('locale', __('Language'))->options(["FR" => "Français", "KG" => "Kikongo", "LN" => "Lingala", "TS" => "Tshiluba", "SW" => "Swahili"])->default("FR")->required();
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
        return [
            'name'       => 'John Doe',
            'email'      => 'John.Doe@gmail.com',
            'created_at' => now(),
        ];
    }
}
