<?php

namespace App\Jobs;

use App\Form;
use Carbon\Carbon;
use App\Notification;
use Illuminate\Bus\Queueable;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotificationUser implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $dateTimeCarbon = Carbon::today()->toDateString();
    $yearNotification = Carbon::now()->format('Y');
    $listOfRecurrenceForms = ['jour', 'semaine', 'mois', 'année'];
    $betweenWeek = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
    $betweenMonth = [
      Carbon::now()->startOfMonth(),
      Carbon::now()->endOfMonth(),
    ];
    $dayForms = [];

    foreach ($listOfRecurrenceForms as $listOfRecurrenceForm) {
      $query = Form::with(['formRecurrence', 'hospitals.agent'])
        ->where('publish', true)
        ->whereHas('formRecurrence', function ($q) use ($listOfRecurrenceForm) {
          $q->where('name', '=', $listOfRecurrenceForm);
        })
        ->whereDoesntHave('notifications', function ($q) use (
          $dateTimeCarbon,
          $listOfRecurrenceForm,
          $betweenWeek,
          $betweenMonth,
          $yearNotification
        ) {
          if ($listOfRecurrenceForm == 'jour') {
            $q->whereDate('created_at', $dateTimeCarbon);
          }
          if ($listOfRecurrenceForm == 'semaine') {
            $q->whereBetween('created_at', $betweenWeek);
          }
          if ($listOfRecurrenceForm == 'mois') {
            $q->whereBetween('created_at', $betweenMonth);
          }
          if ($listOfRecurrenceForm == 'année') {
            $q->whereYear('created_at', '=', $yearNotification);
          }
        });
      if ($listOfRecurrenceForm == 'semaine') {
        $query = $query->where(
          'form_recurrence_value',
          '=',
          Carbon::now()->dayOfWeek
        );
      }
      if ($listOfRecurrenceForm == 'mois') {
        $query = $query->where(
          'form_recurrence_value',
          '=',
          Carbon::now()->format('j')
        );
      }
      if ($listOfRecurrenceForm == 'année') {
        $query = $query->where(
          'form_recurrence_value',
          '=',
          Carbon::now()->month
        );
      }
      $results = $query->get();
      foreach ($results as $result) {
        array_push($dayForms, $result);
      }
    }
    foreach ($dayForms as $dayForm) {
      Notification::create([
        'title' => 'Rappel de remplissage de formulaire',
        'message' =>
          'Nous vous rappelons que vous devrez remplir le "' .
          $dayForm->title .
          '"',
        'form_id' => $dayForm->id,
      ]);
      event(new NotificationEvent($dayForm));
    }
  }
}
