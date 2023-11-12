<?php

namespace App\Console\Commands;

use App\Jobs\JobAlertJob;
use Illuminate\Console\Command;
use App\Models\JobAlert as JobAlertModel;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class JobAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to user of newly posted jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobAlerts = JobAlertModel::with(['jobListing'])->where(JobAlertModel::STATUS, 'submitted')->get();
        $jobListingSkills = $this->retrieveSkills($jobAlerts);
        $candidates = User::where(User::ROLE, User::ROLE_CANDIDATE)->where(User::IS_COMPLETE, 100)->get();
        foreach ($candidates as $candidate) {
            $skillMatchCount = count(array_intersect($jobListingSkills, $candidate->candidateInfo->skills));
            if ($skillMatchCount > 2) {
                dispatch(new JobAlertJob($candidate, $jobAlerts));
            }
        }
        $jobAlerts->each(function ($jobAlert) {
            $jobAlert->update([
                JobAlertModel::STATUS => 'done'
            ]);
        });
    }

    protected function retrieveSkills($listings) {
        $skillsets = [];
        $listings->each(function ($job) use (&$skillsets) {
            $skillsets = Arr::collapse([$skillsets, $job->jobListing->skills]);
        });
        return array_unique($skillsets);
    }
}
