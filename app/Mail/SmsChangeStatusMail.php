<?php

namespace App\Mail;

use App\SmsDiffusion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SmsChangeStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $smsDiffusion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SmsDiffusion $smsDiffusion)
    {
        $this->smsDiffusion = $smsDiffusion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("")
            ->markdown(
                'mails.smsChangeStatus.blade',
                ['smsDiffusion'=>$this->smsDiffusion]
            );
    }
}
