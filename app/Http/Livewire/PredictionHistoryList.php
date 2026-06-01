<?php

namespace App\Http\Livewire;

use App\Models\PredictionHistory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PredictionHistoryList extends Component
{
    public $perPage = 10;

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

        return view('livewire.prediction-history-list', compact('histories'));
    }
}
