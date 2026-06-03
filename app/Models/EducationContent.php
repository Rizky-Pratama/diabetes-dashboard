<?php

namespace App\Models;

use Database\Factories\EducationContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationContent extends Model
{
    /** @use HasFactory<EducationContentFactory> */
    use HasFactory;

    public const array RESULT_TYPES = ['normal', 'prediabetes', 'diabetes'];

    protected $fillable = [
        'result_type',
        'title',
        'content',
        'status',
    ];

    public function getResultTypeLabelAttribute(): string
    {
        return match ($this->result_type) {
            'normal' => 'Normal',
            'prediabetes' => 'Prediabetes',
            'diabetes' => 'Diabetes',
            default => 'Tidak diketahui',
        };
    }
}
