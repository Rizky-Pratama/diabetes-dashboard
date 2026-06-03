<?php

namespace App\Http\Livewire;

use App\Models\PredictionHistory;
use App\Services\PythonPredictionClient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PredictionManager extends Component
{
    use WithPagination;

    public $glucose;

    public $blood_pressure;

    public $insulin;

    public $bmi;

    public $age;

    public $loading = false;

    public int $perPage = 10;

    protected $rules = [
        'glucose' => 'required|numeric|min:0',
        'blood_pressure' => 'required|numeric|min:0',
        'insulin' => 'required|numeric|min:0',
        'bmi' => 'required|numeric|min:0',
        'age' => 'required|integer|min:0',
    ];

    public function submit(PythonPredictionClient $client)
    {
        $this->validate();

        $this->loading = true;

        try {
            $payload = [
                'glucose' => $this->glucose,
                'blood_pressure' => $this->blood_pressure,
                'insulin' => $this->insulin,
                'bmi' => $this->bmi,
                'age' => $this->age,
            ];

            $response = $client->predict($payload) ?? [];

            $user = Auth::user();

            PredictionHistory::create([
                'clinic_id' => $user->clinic_id ?? null,
                'user_id' => $user->id ?? null,
                'glucose' => $this->glucose,
                'blood_pressure' => $this->blood_pressure,
                'insulin' => $this->insulin,
                'bmi' => $this->bmi,
                'age' => $this->age,
                'probability' => $response['probability'] ?? null,
                'result' => $response['risk_label'] ?? null,
            ]);

            $this->reset(['glucose', 'blood_pressure', 'insulin', 'bmi', 'age']);
            session()->flash('status', 'Prediksi berhasil disimpan.');
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            $query = PredictionHistory::latest();
        } elseif ($user && $user->role === 'petugas') {
            $query = PredictionHistory::where('clinic_id', $user->clinic_id)->latest();
        } else {
            $query = PredictionHistory::where('user_id', $user->id ?? 0)->latest();
        }

        $histories = $query->paginate($this->perPage);

        return view('livewire.prediction-manager', compact('histories'));
    }
}
