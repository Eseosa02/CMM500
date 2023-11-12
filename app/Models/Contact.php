<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const SUBJECT = 'subject';
    const MESSAGE = 'message';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::SUBJECT,
        self::MESSAGE,
    ];
}
