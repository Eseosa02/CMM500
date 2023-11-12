<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobAlertMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $joblistings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $joblistings)
    {
        $this->user = $user;
        $this->joblistings = $joblistings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'))
                    ->subject(env('APP_NAME') . ' Job Alert!')
                    ->view('mails.job_alert')
                    ->with([
                        'user' => $this->user,
                        'joblistings' => $this->joblistings,
                    ]);
    }
}
