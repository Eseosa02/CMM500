<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $jobApplication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $jobApplication)
    {
        $this->user = $user;
        $this->jobApplication = $jobApplication;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
                    ->subject(env('APP_NAME') . ' Job Notification!')
                    ->view('mails.job_notification')
                    ->with([
                        'user' => $this->user,
                        'jobApplication' => $this->jobApplication,
                    ]);
    }
}
