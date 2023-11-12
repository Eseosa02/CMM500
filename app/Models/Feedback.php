<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    const ID = 'id';
    const JOB_LISTING_ID = 'job_listing_id';
    const USER_ID = 'user_id';
    const RATING = 'rating';
    const MESSAGE = 'message';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::JOB_LISTING_ID,
        self::USER_ID,
        self::RATING,
        self::MESSAGE,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    public function candidate() {
        return $this->belongsTo(User::class, self::USER_ID);
    }

    public function jobListing() {
        return $this->belongsTo(JobListing::class, self::JOB_LISTING_ID);
    }
}
