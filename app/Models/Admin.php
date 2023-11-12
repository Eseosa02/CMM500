<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const PASSWORD = 'password';
    const STATUS = 'status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::PHONE,
        self::PASSWORD,
        self::STATUS,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::PASSWORD,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function setPasswordAttribute($password)
    {
        $this->attributes[self::PASSWORD] = Hash::make($password);
    }
}
