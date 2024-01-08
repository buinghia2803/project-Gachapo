<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Business\MailTemplateBusiness;
use Mail;
use App\Mail\MailTemplate;

class SendMailTemplate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailType;
    protected $mailTo;
    protected $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailType, $mailTo, $params = [])
    {
        $this->mailType = $mailType;
        $this->mailTo = $mailTo;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MailTemplateBusiness $mailTemplateBusiness)
    {

        $mailTemplate = $mailTemplateBusiness->getMailTemplateByType($this->mailType);
        if ($mailTemplate != null) {
            Mail::to($this->mailTo)->send(new MailTemplate($mailTemplate, $this->params));
        }
    }
}
