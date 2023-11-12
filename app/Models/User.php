<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    const NAME = 'name';
    const EMAIL = 'email';
    const EMAIL_VERIFIED_AT = 'email_verified_at';
    const PASSWORD = 'password';
    const STATUS = 'status';
    const IS_COMPLETE = 'isComplete';
    const ROLE = 'role';
    const REMEMBER_TOKEN = 'remember_token';
    
    const ROLE_CANDIDATE = 'candidate';
    const ROLE_EMPLOYER = 'employer';
    const FK_USER_ID = 'user_id';
    const JOB_LISTING_ID = 'job_listing_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::EMAIL_VERIFIED_AT,
        self::PASSWORD,
        self::STATUS,
        self::ROLE,
        self::IS_COMPLETE,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::EMAIL_VERIFIED_AT => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes[self::PASSWORD] = Hash::make($password);
    }

    public function isCandidate() {
        if ($this->role === self::ROLE_CANDIDATE) {
            return true;
        }
        return false;
    }

    public function isEmployer() {
        if ($this->role === self::ROLE_EMPLOYER) {
            return true;
        }
        return false;
    }

    public function candidateInfo() {
        return $this->hasOne(UserProfile::class, self::FK_USER_ID);
    }

    public function candidateEducations() {
        return $this->hasMany(UserEducation::class, self::FK_USER_ID);
    }

    public function candidateExperiences() {
        return $this->hasMany(UserExperience::class, self::FK_USER_ID);
    }

    public function candidateJobNotifications() {
        return $this->hasMany(JobNotification::class, self::FK_USER_ID);
    }

    public function candidateSavedJobs() {
        return $this->hasMany(SavedJob::class, self::FK_USER_ID);
    }

    public function employerInfo() {
        return $this->hasOne(EmployerProfile::class, self::FK_USER_ID);
    }

    public function jobApplications() {
        return $this->hasMany(JobApplication::class, self::FK_USER_ID);
    }

    public function jobListings() {
        return $this->hasMany(JobListing::class, self::FK_USER_ID);
    }

    public function candidateCVs() {
        return $this->hasMany(UserCv::class, self::FK_USER_ID);
    }

    public function candidateFeedbacks() {
        return $this->hasMany(Feedback::class, self::FK_USER_ID);
    }

    public function defaultCandidateCV() {
        return $this->candidateCVs()->where('is_default', 1)->first();
    }

    public function userImage() {
        if ($this->isCandidate()) {
            /** @var UserProfile $profile */
            return $this->candidateInfo->image;
        }
        if ($this->isEmployer()) {
            /** @var EmployerProfile $profile */
            return $this->employerInfo->image;
        }
        return null;
    }

}
