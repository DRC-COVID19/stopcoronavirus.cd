<?php

namespace App\Listeners;

use App\Hospital;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationListener
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  object  $event
   * @return void
   */
  public function handle($event)
  {
    if ($event->form->visible_all_hospitals) {
      $hospitals = Hospital::with('agent')->get();
      foreach ($hospitals as $hospital) {
        if ($hospital->agent) {
          Mail::to($hospital->agent->email)->send(
            new NotificationMail($event->form)
          );
        }
      }
    } else {
      foreach ($event->form->hospitals as $hospital) {
        Mail::to($hospital->agent->email)->send(
          new NotificationMail($event->form)
        );
      }
    }
  }
}
