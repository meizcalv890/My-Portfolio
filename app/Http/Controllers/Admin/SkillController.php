<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => 'required|max:80',
            'level' => 'required|integer|min:1|max:100',
            'icon_slug' => ['nullable', 'max:60', 'regex:/^[a-z0-9]+$/'],
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:1024',
            'remove_icon' => 'nullable|boolean',
        ];
    }

    private function normalizeSlug(Request $request): void
    {
        $request->merge([
            'icon_slug' => $request->filled('icon_slug')
                ? strtolower(trim($request->input('icon_slug')))
                : null,
        ]);
    }

    public function index()
    {
        return view('admin.skills.index', ['skills' => Skill::orderByDesc('level')->get()]);
    }

    public function store(Request $request)
    {
        $this->normalizeSlug($request);
        $data = $request->validate($this->rules());

        $attrs = Arr::only($data, ['name', 'level', 'icon_slug']);
        if ($request->hasFile('icon')) {
            $attrs['icon'] = $request->file('icon')->store('skills', 'public');
        }

        Skill::create($attrs);

        return back()->with('success', 'Skill ditambahkan');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $this->normalizeSlug($request);
        $data = $request->validate($this->rules());

        $attrs = Arr::only($data, ['name', 'level', 'icon_slug']);

        if ($request->hasFile('icon')) {
            if ($skill->icon) {
                Storage::disk('public')->delete($skill->icon);
            }
            $attrs['icon'] = $request->file('icon')->store('skills', 'public');
        } elseif ($request->boolean('remove_icon') && $skill->icon) {
            Storage::disk('public')->delete($skill->icon);
            $attrs['icon'] = null;
        }

        $skill->update($attrs);

        return redirect()->route('admin.skills.index')->with('success', 'Skill diperbarui');
    }

    public function destroy(Skill $skill)
    {
        if ($skill->icon) {
            Storage::disk('public')->delete($skill->icon);
        }
        $skill->delete();

        return back()->with('success', 'Skill dihapus');
    }
}
