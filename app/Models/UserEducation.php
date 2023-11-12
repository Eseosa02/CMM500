<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;

    const USER_ID = 'user_id';
    const TITLE = 'title';
    const INSTITUTION = 'institution';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const GRADE = 'grade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::USER_ID,
        self::TITLE,
        self::INSTITUTION,
        self::START_DATE,
        self::END_DATE,
        self::GRADE,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::START_DATE => 'date:d-m-Y',
        self::END_DATE => 'date:d-m-Y',
    ];
}
