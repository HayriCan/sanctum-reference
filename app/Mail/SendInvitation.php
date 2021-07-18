<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $code;

    /**
     * SendEmail constructor.
     * @param $m_code
     */
    public function __construct($m_code)
    {
        $this->subject = config('app.name').' Katılım Davetiyesi';
        $this->code = $m_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('emails.send-email')
            ->with('code',$this->code)
            ->subject($this->subject);
    }
}
