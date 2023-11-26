<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerProfile extends Model
{
    use HasFactory;

    const USER_ID = 'user_id';
    const UNIQUE_ID = 'unique_id';
    const DESCRIPTION = 'description';
    const PHONE = 'phone';
    const INDUSTRY = 'industry';
    const COMPANY_SIZE = 'company_size';
    const IMAGE = 'image';
    const DOCUMENT = 'document';
    const FOUNDED = 'founded';
    const ADDRESS = 'address';
    const CITY = 'city';
    const COUNTRY = 'country';
    const FB_LINK = 'fb_link';
    const TW_LINK = 'tw_link';
    const IN_LINK = 'in_link';
    const LINKEDIN_LINK = 'linkedin_link';
    const WEBSITE = 'website';
    const APPROVAL = 'approval';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::USER_ID,
        self::UNIQUE_ID,
        self::DESCRIPTION,
        self::PHONE,
        self::INDUSTRY,
        self::COMPANY_SIZE,
        self::IMAGE,
        self::FOUNDED,
        self::CITY,
        self::COUNTRY,
        self::FB_LINK,
        self::TW_LINK,
        self::IN_LINK,
        self::LINKEDIN_LINK,
        self::WEBSITE,
        self::APPROVAL,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::INDUSTRY => 'array'
    ];

    public function setIndustryAttribute($industry)
    {
        $this->attributes[self::INDUSTRY] = json_encode($industry);
    }

    public function employer () {
        return $this->belongsTo(User::class, self::USER_ID);
    }
}
