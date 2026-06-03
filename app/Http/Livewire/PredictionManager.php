<?php

namespace App\Http\Livewire;

use App\Models\EducationContent;
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

    public $patient_name;

    public $lastEducation = null;

    public ?string $lastPredictionResult = null;

    public int $perPage = 10;

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        $patientNameRule = Auth::user()?->role === 'petugas'
            ? 'required|string|max:255'
            : 'nullable|string|max:255';

        return [
            'glucose' => 'required|numeric|min:0',
            'blood_pressure' => 'required|numeric|min:0',
            'insulin' => 'required|numeric|min:0',
            'bmi' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0',
            'patient_name' => $patientNameRule,
        ];
    }

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
            $isClinicOfficer = $user?->role === 'petugas';
            $result = $this->normalizePredictionResult($response['risk_label'] ?? $response['result'] ?? null);

            PredictionHistory::create([
                'clinic_id' => $isClinicOfficer ? $user->clinic_id : null,
                'user_id' => $isClinicOfficer ? null : $user?->id,
                'input_by' => $isClinicOfficer ? $user?->id : null,
                'patient_name' => $isClinicOfficer ? $this->patient_name : null,
                'glucose' => $this->glucose,
                'blood_pressure' => $this->blood_pressure,
                'insulin' => $this->insulin,
                'bmi' => $this->bmi,
                'age' => $this->age,
                'probability' => $response['probability'] ?? null,
                'result' => $result,
            ]);

            $education = EducationContent::where('result_type', $result)
                ->where('status', 'published')
                ->latest()
                ->first();

            $this->lastPredictionResult = $result;
            $this->lastEducation = $education?->only(['title', 'content', 'result_type']);

            $this->reset(['glucose', 'blood_pressure', 'insulin', 'bmi', 'age', 'patient_name']);
            session()->flash('status', 'Prediksi berhasil disimpan.');
        } finally {
            $this->loading = false;
        }
    }

    protected function normalizePredictionResult(?string $result): string
    {
        $normalizedResult = str($result ?? 'normal')->lower()->replace(['_', '-'], ' ')->squish()->toString();

        return match (true) {
            str_contains($normalizedResult, 'tidak') || str_contains($normalizedResult, 'normal') => 'normal',
            str_contains($normalizedResult, 'pre') || str_contains($normalizedResult, 'pra') || str_contains($normalizedResult, 'sedang') => 'prediabetes',
            str_contains($normalizedResult, 'diabetes') || str_contains($normalizedResult, 'tinggi') => 'diabetes',
            default => 'normal',
        };
    }

    public function render()
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            $query = PredictionHistory::with('user', 'inputBy', 'clinic')->latest();
        } elseif ($user && $user->role === 'petugas') {
            $query = PredictionHistory::with('user', 'inputBy', 'clinic')->where('clinic_id', $user->clinic_id)->latest();
        } else {
            $query = PredictionHistory::with('user', 'inputBy', 'clinic')->where('user_id', $user->id ?? 0)->latest();
        }

        $histories = $query->paginate($this->perPage);

        return view('livewire.prediction-manager', compact('histories'));
    }
}
