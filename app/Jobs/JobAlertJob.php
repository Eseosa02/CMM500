<?php

namespace App\Jobs;

use App\Mail\JobAlertMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class JobAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $joblistings;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $joblistings)
    {
        $this->user = $user;
        $this->joblistings = $joblistings;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new JobAlertMail($this->user, $this->joblistings));
    }
}
