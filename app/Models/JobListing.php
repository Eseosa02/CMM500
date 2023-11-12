<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    const ID = 'id';
    const USER_ID = 'user_id';
    const CATEGORY_ID = 'category_id';
    const JOB_REFERENCE = 'job_reference';
    const TITLE = 'title';
    const TITLE_SLUG = 'title_slug';
    const DESCRIPTION = 'description';
    const CONTRACT_TYPE = 'contract_type';
    const PRIORITY = 'priority';
    const EXPERIENCE = 'experience';
    const CITY = 'city';
    const COUNTRY = 'country';
    const SALARY = 'salary';
    const EXPIRY_DATE = 'expiry_date';
    const HOURS = 'hours';
    const SKILLS = 'skills';
    const VIEWS = 'views';
    const STATUS = 'status';

    const FK_JOB_LISTING_ID = 'job_listing_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::JOB_REFERENCE,
        self::USER_ID,
        self::CATEGORY_ID,
        self::TITLE,
        self::TITLE_SLUG,
        self::DESCRIPTION,
        self::CONTRACT_TYPE,
        self::PRIORITY,
        self::EXPERIENCE,
        self::CITY,
        self::COUNTRY,
        self::SALARY,
        self::EXPIRY_DATE,
        self::HOURS,
        self::SKILLS,
        self::STATUS,
        self::VIEWS,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::EXPIRY_DATE => 'datetime',
        self::SKILLS => 'array',
        self::EXPERIENCE => 'array'
    ];

    public function setSkillsAttribute($skills)
    {
        $this->attributes[self::SKILLS] = json_encode($skills);
    }

    public function setExperienceAttribute($experience)
    {
        $this->attributes[self::EXPERIENCE] = json_encode($experience);
    }

    public function employer () {
        return $this->belongsTo(User::class, self::USER_ID);
    }

    public function jobApplications () {
        return $this->hasMany(JobApplication::class, self::FK_JOB_LISTING_ID);
    }

    public function category () {
       return $this->belongsTo(Category::class, self::CATEGORY_ID);
    }
}
