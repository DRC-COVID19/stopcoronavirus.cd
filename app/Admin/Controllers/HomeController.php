<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;

class HomeController extends Controller
{
  public function index(Content $content)
  {
    if (
      !Admin::user()->isAdministrator() &&
      (Admin::user()->can('telco') ||
        Admin::user()->can('validator_sms') ||
        Admin::user()->can('operator_sms'))
    ) {
      return redirect()->route('sms-diffusions.index');
    }
    return $content
      ->title('Dashboard')
      ->description('Description...')
      ->row(Dashboard::title())
      ->row(function (Row $row) {
        $row->column(4, function (Column $column) {
          $column->append(Dashboard::environment());
        });

        $row->column(4, function (Column $column) {
          $column->append(Dashboard::extensions());
        });

        $row->column(4, function (Column $column) {
          $column->append(Dashboard::dependencies());
        });
      });
  }
}
