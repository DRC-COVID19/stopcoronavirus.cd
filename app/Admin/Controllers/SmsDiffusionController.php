<?php

namespace App\Admin\Controllers;

use App\Mail\SmsChangeStatusMail;
use App\SmsDiffusion;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SmsDiffusionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\SmsDiffusion';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SmsDiffusion());
        $grid->column('status', __('Status'));
        $grid->column('content_fr', __('Content fr'));
        $grid->column('date_diffusion', __('Date diffusion'));
        $grid->column('created_at', __('Date création'));
        $grid->column('updated_at', __('Date de mise à jour'));
        if (Admin::user()->can('telco')) {
            $grid->model()->where('status', 'VALIDATED');
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });
        }
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
        //TODO: Check user role here

        $show = new Show(SmsDiffusion::findOrFail($id));

        $show->field('status', __('Status'));
        $show->field('content_fr', __('Content fr'));
        $show->field('content_li', __('Content li'));
        $show->field('content_sw', __('Content sw'));
        $show->field('content_ts', __('Content ts'));
        $show->field('content_ki', __('Content ki'));
        $show->field('date_diffusion', __('Date diffusion'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SmsDiffusion());
        if (Admin::user()->can('validator_sms')) {
            $form->select('status', __('Status'))->options(["DRAFT" => "Draft", "VALIDATED" => "Validé"]);
        } else {
            $form->select('status', __('Status'))->options(["DRAFT" => "Draft", "VALIDATED" => "Validé"])->default("DRAFT")->disable();
        }
        $form->textarea('content_fr', __('Content (FR)'));
        $form->textarea('content_li', __('Content (Lingala)'));
        $form->textarea('content_sw', __('Content (Swahili)'));
        $form->textarea('content_ts', __('Content (Tshiluba)'));
        $form->textarea('content_ki', __('Content (Kikongo)'));
        $form->datetime('date_diffusion', __('Date diffusion'))->default(date('Y-m-d H:i:s'));

        $form->saving(function (Form $form) {
            if (Admin::user()->can('operator_sms') && is_null($form->status)) {
                $form->status="DRAFT";
            }
        });
        $form->saved(function (Form $form) {
            if (Admin::user()->can('validator_sms') && $form->model()->status == "VALIDATED") {
                $operators = DB::table('admin_users')
                    ->join('admin_user_permissions', 'admin_users.id', '=', 'admin_user_permissions.user_id')
                    ->join('admin_permissions', 'admin_permissions.id', 'permission_id')
                    ->where('admin_permissions', 'telco')
                    ->get();
                foreach ($operators as $value) {
                    Mail::to($value->email)->send(new SmsChangeStatusMail($form->model()));
                }
            }
        });

        return $form;
    }
}
