<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    private function rules(): array
    {
        return ['name' => 'required|max:80', 'level' => 'required|integer|min:1|max:100'];
    }

    public function index()
    {
        return view('admin.skills.index', ['skills' => Skill::orderByDesc('level')->get()]);
    }

    public function store(Request $request)
    {
        Skill::create($request->validate($this->rules()));
        return back()->with('success', 'Skill ditambahkan');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $skill->update($request->validate($this->rules()));
        return redirect()->route('admin.skills.index')->with('success', 'Skill diperbarui');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill dihapus');
    }
}
