<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RoomDesign;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_designs' => RoomDesign::count(),
            'total_styles' => Style::count(),
            'recent_activity' => RoomDesign::with('user')->latest()->take(5)->get(),
            'user_growth' => User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->take(7)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function subscriptions()
    {
        // Mocking subscriptions since we only have User model and manual receipt flow
        $pendingReceipts = User::whereNotNull('email_verified_at')->take(3)->get(); // Mock logic
        return view('admin.subscriptions', compact('pendingReceipts'));
    }

    public function settings()
    {
        $credentials = [
            'stability_ai' => 'sk-************************',
            'openai' => 'sk-proj-************************',
            'firebase_project_id' => 'homiq-ai-prod',
        ];
        
        $styles = Style::all();

        return view('admin.settings', compact('credentials', 'styles'));
    }
}
