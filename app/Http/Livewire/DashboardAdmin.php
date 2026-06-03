<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Clinic;
use App\Models\EducationContent;
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
            'education_contents' => EducationContent::count(),
            'recent_histories' => PredictionHistory::with('user', 'inputBy', 'clinic')->latest()->limit(5)->get(),
            'recent_articles' => Article::latest()->limit(4)->get(),
            'diabetes_count' => PredictionHistory::where('result', 'diabetes')->count(),
            'prediabetes_count' => PredictionHistory::where('result', 'prediabetes')->count(),
            'normal_count' => PredictionHistory::where('result', 'normal')->count(),
        ];

        return view('livewire.dashboard-admin', compact('data'));
    }
}
