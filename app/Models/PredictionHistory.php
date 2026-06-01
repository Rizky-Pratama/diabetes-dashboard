<?php

namespace App\Models;

use Database\Factories\PredictionHistoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredictionHistory extends Model
{
    /** @use HasFactory<PredictionHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'user_id',
        'glucose',
        'blood_pressure',
        'insulin',
        'bmi',
        'age',
        'probability',
        'result',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
