<?php

namespace App\Admin\Forms\Alert;

use App\Alert;
use App\AlertTranslation;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\StepForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertForm extends StepForm
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Resumé';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        try {
            DB::beginTransaction();
            if (isset($this->all()['alert_info']['id'])) {
                $dataAlert=$this->all()['alert_info'];
                Alert::find($dataAlert['id'])->update();
                AlertTranslation::find($this->all()['alert_fr']['id'])->update($this->all()['alert_fr']);
                AlertTranslation::find($this->all()['alert_kg']['id'])->update($this->all()['alert_kg']);
                AlertTranslation::find($this->all()['alert_ln']['id'])->update($this->all()['alert_ln']);
                AlertTranslation::find($this->all()['alert_sw']['id'])->update($this->all()['alert_sw']);
                AlertTranslation::find($this->all()['alert_ts']['id'])->update($this->all()['alert_ts']);
            } else {
                $alert = Alert::create([]);
                AlertTranslation::create(array_merge($this->all()['alert_fr'], ['alert_id' => $alert->id]));
                AlertTranslation::create(array_merge($this->all()['alert_kg'], ['alert_id' => $alert->id]));
                AlertTranslation::create(array_merge($this->all()['alert_ln'], ['alert_id' => $alert->id]));
                AlertTranslation::create(array_merge($this->all()['alert_sw'], ['alert_id' => $alert->id]));
                AlertTranslation::create(array_merge($this->all()['alert_ts'], ['alert_id' => $alert->id]));
            }
            Db::commit();
            $this->clear();
            admin_success('Processed successfully.');
            return redirect()->route('alerts.index');
        } catch (\Throwable $th) {
            DB::rollback();
            admin_error($th->getMessage());
            return back();
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
       $this->hidden('id');
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
