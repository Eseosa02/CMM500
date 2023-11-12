<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    const USER_ID = 'user_id';
    const UNIQUE_ID = 'unique_id';
    const TITLE = 'title';
    const PHONE = 'phone';
    const DESCRIPTION = 'description';
    const DOB = 'dob';
    const GENDER = 'gender';
    const EXPERIENCE = 'experience';
    const EDUCATION = 'education';
    const CITY = 'city';
    const COUNTRY = 'country';
    const SKILLS = 'skills';
    const RATING = 'rating';
    const CURRENT_SALARY = 'current_salary';
    const IMAGE = 'image';
    const FB_LINK = 'fb_link';
    const TW_LINK = 'tw_link';
    const IN_LINK = 'in_link';
    const LINKEDIN_LINK = 'linkedin_link';
    const WEBSITE = 'website';
    const SEXUAL_ORIENTATION = 'sexuality';
    const DISABILITY = 'disability';
    const RELIGION = 'religion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::USER_ID,
        self::UNIQUE_ID,
        self::TITLE,
        self::PHONE,
        self::DESCRIPTION,
        self::DOB,
        self::GENDER,
        self::EXPERIENCE,
        self::EDUCATION,
        self::CITY,
        self::COUNTRY,
        self::SKILLS,
        self::RATING,
        self::CURRENT_SALARY,
        self::IMAGE,
        self::FB_LINK,
        self::TW_LINK,
        self::IN_LINK,
        self::LINKEDIN_LINK,
        self::WEBSITE,
        self::SEXUAL_ORIENTATION,
        self::DISABILITY,
        self::RELIGION,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::RATING => 'array',
        self::SKILLS => 'array'
    ];

    public function setSkillsAttribute($skills)
    {
        $this->attributes[self::SKILLS] = json_encode($skills);
    }

    public function getSkillsAttribute($skills)
    {
        return json_decode($skills);
    }

    public function setRatingAttribute($rating)
    {
        $this->attributes[self::RATING] = json_encode($rating);
    }

    public function getRatingAttribute($rating)
    {
        return json_decode($rating, true);
    }

    public function candidate () {
        return $this->belongsTo(User::class, self::USER_ID);
    }
}
