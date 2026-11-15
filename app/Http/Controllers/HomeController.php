<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('category')
            ->when($request->category, function ($query, $slug) {
                $query->whereHas('category', fn($w) => $w->where('slug', $slug));
            })
            ->when($request->q, function ($query, $s) {
                $query->where(function ($w) use ($s) {
                    $w->where('title', 'like', "%{$s}%")
                        ->orWhere('tech_stack', 'like', "%{$s}%");
                });
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('home', [
            'profile' => Profile::current(),
            'projects' => $projects,
            'skills' => Skill::orderByDesc('level')->get(),
            'categories' => Category::orderBy('name')->get(),
            'experiences' => Experience::orderByDesc('start_date')->get(),
        ]);
    }

    public function show(Project $project)
    {
        $project->load(['category', 'images']);

        return view('project-show', compact('project'));
    }

    public function contact(Request $request)
    {
        // Honeypot: kolom ini tersembunyi, hanya bot yang mengisinya
        if ($request->filled('website')) {
            return redirect()->to(route('home') . '#kontak')->with('success', 'Pesan terkirim, terima kasih!');
        }

        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:150',
            'body' => 'required|max:2000',
        ]);

        Message::create($data);

        return redirect()->to(route('home') . '#kontak')->with('success', 'Pesan terkirim, terima kasih!');
    }
}
