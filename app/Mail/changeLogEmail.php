<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class changeLogEmail extends Mailable
{
  use Queueable, SerializesModels;

  protected $user;
  protected $changeLog;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($user, $changeLog)
  {
    $this->user = $user;
    $this->changeLog = $changeLog;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->markdown('mails.change_log_email', [
      'user' => $this->user,
      'changeLog' => $this->changeLog,
    ]);
  }
}
