<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    use HasFactory;

    const ID = 'id';
    const JOB_LISTING_ID = 'job_listing_id';
    const STATUS = 'status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::JOB_LISTING_ID,
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
}
