<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateCouponMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $coupon;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $coupon = $this->coupon;
        return $this->subject("[Gachapo] 最新のクーポンコード")
            ->view('emails.create-new-coupon', [
                'coupon' => $coupon
            ]);
    }
}
