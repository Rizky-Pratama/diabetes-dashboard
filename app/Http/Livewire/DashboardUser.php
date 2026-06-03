<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\EducationContent;
use App\Models\PredictionHistory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardUser extends Component
{
    public function render()
    {
        $user = Auth::user();

        $last = PredictionHistory::where('user_id', $user->id ?? 0)->latest()->first();
        $histories = PredictionHistory::where('user_id', $user->id ?? 0)->latest()->limit(5)->get();
        $articles = Article::where('status', 'published')->latest()->limit(4)->get();
        $education = $last ? EducationContent::where('result_type', $last->result)->where('status', 'published')->latest()->first() : null;

        return view('livewire.dashboard-user', compact('last', 'histories', 'articles', 'education'));
    }
}
