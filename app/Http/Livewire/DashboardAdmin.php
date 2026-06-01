<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Clinic;
use App\Models\PredictionHistory;
use App\Models\User;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public function render()
    {
        $data = [
            'clinics' => Clinic::count(),
            'users' => User::count(),
            'predictions' => PredictionHistory::count(),
            'articles' => Article::count(),
            'recent_histories' => PredictionHistory::with('user', 'clinic')->latest()->limit(5)->get(),
            'recent_articles' => Article::with('clinic')->latest()->limit(4)->get(),
            'risk_count' => PredictionHistory::where('result', 'Risiko Diabetes')->count(),
            'safe_count' => PredictionHistory::where('result', '!=', 'Risiko Diabetes')->count(),
        ];

        return view('livewire.dashboard-admin', compact('data'));
    }
}
