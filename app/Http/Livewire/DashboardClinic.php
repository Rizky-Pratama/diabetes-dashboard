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
      'risk_count' => PredictionHistory::where('clinic_id', $clinicId)->where('result', 'Risiko Diabetes')->count(),
      'safe_count' => PredictionHistory::where('clinic_id', $clinicId)->where('result', '!=', 'Risiko Diabetes')->count(),
      'recent_histories' => PredictionHistory::where('clinic_id', $clinicId)->with('user')->latest()->limit(6)->get(),
    ];

    return view('livewire.dashboard-clinic', compact('data'));
  }
}
