<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    private function rules(): array
    {
        $max = now()->year + 1;

        return [
            'type' => 'required|in:work,education',
            'title' => 'required|max:150',
            'organization' => 'required|max:150',
            'location' => 'nullable|max:100',
            'start_year' => "required|integer|min:1950|max:{$max}",
            'end_year' => "nullable|integer|min:1950|max:{$max}|gte:start_year",
            'description' => 'nullable|max:3000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_photo' => 'nullable|boolean',
        ];
    }

    /** Ubah tahun dari form menjadi kolom tanggal di database. */
    private function attributes(array $data): array
    {
        $attrs = Arr::except($data, ['photo', 'remove_photo', 'start_year', 'end_year']);
        $attrs['start_date'] = $data['start_year'] . '-01-01';
        $attrs['end_date'] = ! empty($data['end_year']) ? $data['end_year'] . '-12-31' : null;

        return $attrs;
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
        $data = $request->validate($this->rules());

        $attrs = $this->attributes($data);
        if ($request->hasFile('photo')) {
            $attrs['photo'] = $request->file('photo')->store('experiences', 'public');
        }

        Experience::create($attrs);

        return redirect()->route('admin.experiences.index')->with('success', 'Data ditambahkan');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $request->validate($this->rules());

        $attrs = $this->attributes($data);

        if ($request->hasFile('photo')) {
            if ($experience->photo) {
                Storage::disk('public')->delete($experience->photo);
            }
            $attrs['photo'] = $request->file('photo')->store('experiences', 'public');
        } elseif ($request->boolean('remove_photo') && $experience->photo) {
            Storage::disk('public')->delete($experience->photo);
            $attrs['photo'] = null;
        }

        $experience->update($attrs);

        return redirect()->route('admin.experiences.index')->with('success', 'Data diperbarui');
    }

    public function destroy(Experience $experience)
    {
        if ($experience->photo) {
            Storage::disk('public')->delete($experience->photo);
        }
        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('success', 'Data dihapus');
    }
}
