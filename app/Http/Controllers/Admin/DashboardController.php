<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'skillCount' => Skill::count(),
            'messageCount' => Message::count(),
            'unread' => Message::where('is_read', false)->count(),
            'latest' => Message::latest()->take(5)->get(),
        ]);
    }
}
