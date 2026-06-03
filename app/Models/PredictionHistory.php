<?php

namespace App\Models;

use Database\Factories\PredictionHistoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PredictionHistory extends Model
{
    /** @use HasFactory<PredictionHistoryFactory> */
    use HasFactory;

    public const array RESULTS = ['normal', 'prediabetes', 'diabetes'];

    protected $fillable = [
        'clinic_id',
        'user_id',
        'input_by',
        'patient_name',
        'glucose',
        'blood_pressure',
        'insulin',
        'bmi',
        'age',
        'probability',
        'result',
    ];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inputBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'input_by');
    }

    public function getResultLabelAttribute(): string
    {
        return match ($this->result) {
            'normal' => 'Normal',
            'prediabetes' => 'Prediabetes',
            'diabetes' => 'Diabetes',
            default => 'Tidak ada hasil',
        };
    }

    public function getResultBadgeClassesAttribute(): string
    {
        return match ($this->result) {
            'diabetes' => 'bg-rose-50 text-rose-700',
            'prediabetes' => 'bg-amber-50 text-amber-700',
            default => 'bg-emerald-50 text-emerald-700',
        };
    }
}
