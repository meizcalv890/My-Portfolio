<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    private const MAX_GALLERY = 8;

    private function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|max:150',
            'year' => 'nullable|digits:4',
            'role' => 'nullable|max:150',
            'description' => 'required|max:5000',
            'problem' => 'nullable|max:3000',
            'result' => 'nullable|max:3000',
            'tech_stack' => 'nullable|max:255',
            'url' => 'nullable|url|starts_with:http://,https://|max:255',
            'repo_url' => 'nullable|url|starts_with:http://,https://|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images' => 'nullable|array|max:' . self::MAX_GALLERY,
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ];
    }

    private function storeGallery(Request $request, Project $project): void
    {
        foreach (array_filter($request->file('images', [])) as $file) {
            $project->images()->create(['path' => $file->store('projects/gallery', 'public')]);
        }
    }

    public function index()
    {
        return view('admin.projects.index', [
            'projects' => Project::with('category')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.projects.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $attrs = Arr::except($data, ['image', 'images', 'remove_images']);
        $attrs['slug'] = Str::slug($data['title']) . '-' . Str::lower(Str::random(5));
        if ($request->hasFile('image')) {
            $attrs['image'] = $request->file('image')->store('projects', 'public');
        }

        $project = Project::create($attrs);
        $this->storeGallery($request, $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project ditambahkan');
    }

    public function edit(Project $project)
    {
        $project->load('images');

        return view('admin.projects.edit', [
            'project' => $project,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate($this->rules());

        $toRemove = $project->images()->whereIn('id', $data['remove_images'] ?? [])->get();
        $incoming = count(array_filter($request->file('images', [])));

        if ($project->images()->count() - $toRemove->count() + $incoming > self::MAX_GALLERY) {
            return back()
                ->withErrors(['images' => 'Maksimal ' . self::MAX_GALLERY . ' gambar galeri per proyek.'])
                ->withInput();
        }

        $attrs = Arr::except($data, ['image', 'images', 'remove_images']);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $attrs['image'] = $request->file('image')->store('projects', 'public');
        }

        foreach ($toRemove as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $project->update($attrs);
        $this->storeGallery($request, $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project diperbarui');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        foreach ($project->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project dihapus');
    }
}
