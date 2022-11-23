<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\StepForm;

class PandemicCapacityForm extends StepForm
{
  /**
   * The form title.
   *
   * @var string
   */
  public $title = 'Capacité de prise en charge';

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
    $this->text('name')->rules('required');
    $this->email('email')->rules('email');
    $this->datetime('created_at');
  }

  /**
   * The data of the form.
   *
   * @return array $data
   */
  public function data()
  {
    return [
      'name' => 'John Doe',
      'email' => 'John.Doe@gmail.com',
      'created_at' => now(),
    ];
  }
}