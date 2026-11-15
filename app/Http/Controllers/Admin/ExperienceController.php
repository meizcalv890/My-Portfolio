<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    private function rules(): array
    {
        return [
            'type' => 'required|in:work,education',
            'title' => 'required|max:150',
            'organization' => 'required|max:150',
            'location' => 'nullable|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|max:3000',
        ];
    }

    public function index()
    {
        return view('admin.experiences.index', [
            'experiences' => Experience::orderByDesc('start_date')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        Experience::create($request->validate($this->rules()));
        return redirect()->route('admin.experiences.index')->with('success', 'Data ditambahkan');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $experience->update($request->validate($this->rules()));
        return redirect()->route('admin.experiences.index')->with('success', 'Data diperbarui');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'Data dihapus');
    }
}
