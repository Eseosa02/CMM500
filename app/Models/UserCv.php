<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCv extends Model
{
    use HasFactory;

    const ID = 'id';
    const USER_ID = 'user_id';
    const TITLE = 'title';
    const ATTACHMENT = 'attachment';
    const IS_DEFAULT = 'is_default';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::USER_ID,
        self::TITLE,
        self::ATTACHMENT,
        self::IS_DEFAULT,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function candidate () {
        return $this->belongsTo(User::class, self::USER_ID);
    }

}
