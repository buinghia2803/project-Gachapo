<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailTemplate;
    protected $params;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailTemplate, $params = [])
    {
        if (!empty($mailTemplate->subject)) {
            $this->subject($mailTemplate->subject);
        }
        if (!empty($mailTemplate->attachment)) {
            $this->attach($mailTemplate->attachment);
        }
        if (!empty($mailTemplate->cc)) {
            $this->cc(explode(",", $mailTemplate->cc));
        }
        if (!empty($mailTemplate->bcc)) {
            $this->bcc(explode(",", $mailTemplate->bcc));
        }
        $this->template = $mailTemplate->parse($params);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->html('<html>' . $this->template . '</html>', 'text/html');
    }
}
