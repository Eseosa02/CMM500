<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    const ID = 'id';
    const JOB_LISTING_ID = 'job_listing_id';
    const USER_ID = 'user_id';
    const CV_ID = 'cv_id';
    const MESSAGE = 'message';
    const STATUS = 'status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::JOB_LISTING_ID,
        self::USER_ID,
        self::CV_ID,
        self::MESSAGE,
        self::STATUS,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function jobListing () {
        return $this->belongsTo(JobListing::class, self::JOB_LISTING_ID);
    }

    public function candidateCV () {
        return $this->belongsTo(UserCv::class, self::CV_ID);
    }

    public function user () {
        return $this->belongsTo(User::class, self::USER_ID);
    }

    public function candidateInfo () {
        return $this->belongsTo(UserProfile::class, self::USER_ID, self::USER_ID);
    }
}
