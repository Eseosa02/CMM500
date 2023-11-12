<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const TITLE = 'title';

    const FK_CATEGORY_ID = 'category_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::TITLE,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function jobCategoryListing() {
        return $this->hasMany(JobListing::class, self::FK_CATEGORY_ID)->whereNotIn(JobListing::STATUS, ['draft', 'discarded']);
    }
}
