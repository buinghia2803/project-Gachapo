<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordResetMailWeb extends Mailable
{
    use Queueable, SerializesModels;

    protected $secretKey;
    protected $usetInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $usetInfo)
    {
        //
        $this->usetInfo = $usetInfo;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // TODO: Waitting confirm mail template.

        return $this->from(config('mail.from.address'))
            ->subject("[Gachapo] Password Reset!")
            ->view('emails.mail-template')
            ->with(['content' => $this->link, 'title' => $this->usetInfo->name]);
    }
}
