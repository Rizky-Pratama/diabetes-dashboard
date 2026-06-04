<?php

namespace App\Http\Livewire;

use App\Models\EducationContent;
use App\Models\PredictionHistory;
use App\Services\PythonPredictionClient;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class PredictionManager extends Component
{
    use WithPagination;

    public $glucose;

    public $blood_pressure;

    public $insulin;

    public $weight;

    public $height;

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
            'weight' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:1',
            'bmi' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0',
            'patient_name' => $patientNameRule,
        ];
    }

    public function updatedWeight(): void
    {
        $this->calculateBmi();
    }

    public function updatedHeight(): void
    {
        $this->calculateBmi();
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

            $this->reset(['glucose', 'blood_pressure', 'insulin', 'weight', 'height', 'bmi', 'age', 'patient_name']);
            session()->flash('status', 'Prediksi berhasil disimpan.');
        } finally {
            $this->loading = false;
        }
    }

    protected function calculateBmi(): void
    {
        $weight = (float) $this->weight;
        $height = (float) $this->height;

        if ($weight <= 0 || $height <= 0) {
            $this->bmi = null;

            return;
        }

        $heightInMeters = $height / 100;
        $this->bmi = round($weight / ($heightInMeters ** 2), 1);
    }

    /**
     * @return array{label: string, variant: string, description: string, marker: string}
     */
    #[Computed]
    public function bmiCategory(): array
    {
        $bmi = is_numeric($this->bmi) ? (float) $this->bmi : 0.0;

        if ($bmi <= 0) {
            return [
                'label' => 'Belum dihitung',
                'variant' => 'neutral',
                'description' => 'Isi berat dan tinggi badan untuk melihat BMI otomatis.',
                'marker' => '0%',
            ];
        }

        $category = match (true) {
            $bmi < 18.5 => [
                'label' => 'Berat kurang',
                'variant' => 'warning',
                'description' => 'BMI berada di bawah rentang normal.',
            ],
            $bmi < 25 => [
                'label' => 'Normal',
                'variant' => 'success',
                'description' => 'BMI berada pada rentang normal.',
            ],
            $bmi < 30 => [
                'label' => 'Berat berlebih',
                'variant' => 'warning',
                'description' => 'BMI berada di atas rentang normal.',
            ],
            default => [
                'label' => 'Obesitas',
                'variant' => 'danger',
                'description' => 'BMI berada pada rentang obesitas.',
            ],
        };

        return [
            ...$category,
            'marker' => min(100, max(4, ($bmi / 40) * 100)).'%',
        ];
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
