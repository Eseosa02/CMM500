<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobNotification extends Model
{
    use HasFactory;

    const USER_ID = 'user_id';
    const JOB_LISTING_ID = 'job_listing_id';
    const STATUS = 'status';
    const MESSAGE = 'message';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::JOB_LISTING_ID,
        self::USER_ID,
        self::STATUS,
        self::MESSAGE,
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

    public function user () {
        return $this->belongsTo(User::class, self::USER_ID);
    }
}
