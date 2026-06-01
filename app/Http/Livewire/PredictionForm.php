<?php

namespace App\Http\Livewire;

use App\Models\PredictionHistory;
use App\Services\PythonPredictionClient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PredictionForm extends Component
{
    public $glucose;

    public $blood_pressure;

    public $insulin;

    public $bmi;

    public $age;

    public $loading = false;

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

            $history = PredictionHistory::create([
                'clinic_id' => $user->clinic_id ?? null,
                'user_id' => $user->id ?? null,
                'glucose' => $this->glucose,
                'blood_pressure' => $this->blood_pressure,
                'insulin' => $this->insulin,
                'bmi' => $this->bmi,
                'age' => $this->age,
                'probability' => $response['probability'] ?? null,
                'result' => $response['result'] ?? null,
            ]);

            $this->dispatch('predictionSaved', historyId: $history->id);
            session()->flash('status', 'Prediksi berhasil disimpan.');
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.prediction-form');
    }
}
