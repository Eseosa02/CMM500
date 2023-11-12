<?php

namespace App\Jobs;

use App\Mail\JobNotificationMail;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class JobNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $jobApplication;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, JobApplication $jobApplication)
    {
        $this->user = $user;
        $this->jobApplication = $jobApplication;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new JobNotificationMail($this->user, $this->jobApplication));
    }
}
