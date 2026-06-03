<?php

namespace App\Models;

use Database\Factories\ClinicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    /** @use HasFactory<ClinicFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_klinik',
        'logo',
        'alamat',
        'telepon',
        'email',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function predictionHistories()
    {
        return $this->hasMany(PredictionHistory::class);
    }
}
