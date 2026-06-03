<?php

namespace App\Http\Livewire;

use App\Models\Clinic;
use App\Models\PredictionHistory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardClinic extends Component
{
    public function render()
    {
        $user = Auth::user();
        $clinicId = $user->clinic_id ?? null;
        $clinic = Clinic::find($clinicId);

        $data = [
            'clinic' => $clinic,
            'predictions' => PredictionHistory::where('clinic_id', $clinicId)->count(),
            'diabetes_count' => PredictionHistory::where('clinic_id', $clinicId)->where('result', 'diabetes')->count(),
            'prediabetes_count' => PredictionHistory::where('clinic_id', $clinicId)->where('result', 'prediabetes')->count(),
            'normal_count' => PredictionHistory::where('clinic_id', $clinicId)->where('result', 'normal')->count(),
            'recent_histories' => PredictionHistory::where('clinic_id', $clinicId)->with('user', 'inputBy')->latest()->limit(6)->get(),
        ];

        return view('livewire.dashboard-clinic', compact('data'));
    }
}
