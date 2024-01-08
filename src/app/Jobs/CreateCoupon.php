<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Mail\CreateCouponMail;
use Mail;

class CreateCoupon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $coupon;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $coupon)
    {
        $this->email = $email;
        $this->coupon = $coupon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if ($this->email && !empty($this->coupon)) {
                Mail::to($this->email)->send(new CreateCouponMail($this->coupon));
                if (Mail::failures()) {
                    throw new \Exception('Failed to send the email.');
                }
            }
        } catch (\Exception $e) {
            Log::error('[SendMailtCreateNewCoupon->handle: ' . __LINE__ . '] ' . $e->getMessage());
        }
    }
}
