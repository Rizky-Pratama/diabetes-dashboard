<?php

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'status',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
