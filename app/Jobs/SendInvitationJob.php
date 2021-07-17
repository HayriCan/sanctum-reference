<?php

namespace App\Jobs;

use App\Mail\SendInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to;
    public $code;

    /**
     * SendEmailJob constructor.
     * @param $j_mailto
     * @param $j_code
     */
    public function __construct($j_mailto,$j_code)
    {
        $this->to = $j_mailto;
        $this->code = $j_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send(new SendInvitation($this->code));
    }
}
