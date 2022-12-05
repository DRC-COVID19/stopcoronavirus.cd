<?php

namespace App\Mail;

use App\Administrator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AskResetPassword extends Mailable
{
  use Queueable, SerializesModels;

  protected $user;
  protected $code;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(Administrator $user)
  {
    $this->user = $user;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Reinitialisation mot de passe')->markdown(
      'mails.ask_reset_password',
      [
        'reset_link' => route('dashboad.password.reset', [
          $this->user->reset_password_token,
        ]),
        'user' => $this->user,
      ]
    );
  }
}
