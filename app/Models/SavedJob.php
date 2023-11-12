<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    use HasFactory;

    const ID = 'id';
    const FK_USER_ID = 'user_id';
    const FK_JOB_LISTING_ID = 'job_listing_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FK_USER_ID,
        self::FK_JOB_LISTING_ID
    ];

    public function candidate() {
        return $this->belongsTo(User::class, self::FK_USER_ID);
    }
    
    public function jobListing() {
        return $this->belongsTo(JobListing::class, self::FK_JOB_LISTING_ID);
    }
}
