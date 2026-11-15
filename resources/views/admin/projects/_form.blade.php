@csrf
<div class="max-w-2xl space-y-4">
  <div>
    <label for="category_id" class="label">Kategori</label>
    <select id="category_id" name="category_id" class="field">
      <option value="">- Tanpa kategori -</option>
      @foreach($categories as $c)
      <option value="{{ $c->id }}" @selected(old('category_id', $project->category_id ?? '') == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label for="title" class="label">Judul</label>
    <input id="title" name="title" value="{{ old('title', $project->title ?? '') }}" required maxlength="150" class="field">
  </div>

  <div class="grid gap-4 sm:grid-cols-3">
    <div>
      <label for="year" class="label">Tahun</label>
      <input id="year" name="year" value="{{ old('year', $project->year ?? '') }}" placeholder="2026" maxlength="4" class="field">
    </div>
    <div class="sm:col-span-2">
      <label for="role" class="label">Peran Anda</label>
      <input id="role" name="role" value="{{ old('role', $project->role ?? '') }}" placeholder="mis. Pengembang tunggal (back-end dan tampilan)" maxlength="150" class="field">
    </div>
  </div>

  <div>
    <label for="description" class="label">Ringkasan</label>
    <textarea id="description" name="description" rows="4" required maxlength="5000" class="field">{{ old('description', $project->description ?? '') }}</textarea>
  </div>

  <div>
    <label for="problem" class="label">Masalah yang diselesaikan</label>
    <textarea id="problem" name="problem" rows="4" maxlength="3000" class="field">{{ old('problem', $project->problem ?? '') }}</textarea>
  </div>

  <div>
    <label for="result" class="label">Hasil (angka atau bukti nyata lebih baik)</label>
    <textarea id="result" name="result" rows="4" maxlength="3000" class="field">{{ old('result', $project->result ?? '') }}</textarea>
  </div>

  <div>
    <label for="tech_stack" class="label">Teknologi (pisahkan dengan koma)</label>
    <input id="tech_stack" name="tech_stack" value="{{ old('tech_stack', $project->tech_stack ?? '') }}" placeholder="Laravel, MySQL, Tailwind" maxlength="255" class="field">
  </div>

  <div class="grid gap-4 sm:grid-cols-2">
    <div>
      <label for="url" class="label">URL demo</label>
      <input id="url" name="url" value="{{ old('url', $project->url ?? '') }}" placeholder="https://..." maxlength="255" class="field">
    </div>
    <div>
      <label for="repo_url" class="label">URL repository</label>
      <input id="repo_url" name="repo_url" value="{{ old('repo_url', $project->repo_url ?? '') }}" placeholder="https://github.com/..." maxlength="255" class="field">
    </div>
  </div>

  <div>
    <label for="image" class="label">Gambar sampul (16:9, maks 2MB)</label>
    <input id="image" type="file" name="image" accept="image/png,image/jpeg,image/webp" class="w-full text-sm">
    @if(!empty($project->image))
    <img src="{{ asset('storage/'.$project->image) }}" alt="" class="mt-2 h-24 border border-slate-300">
    @endif
  </div>

  <div>
    <label for="images" class="label">Galeri tambahan (maks 8 gambar, masing-masing 2MB)</label>
    <input id="images" type="file" name="images[]" multiple accept="image/png,image/jpeg,image/webp" class="w-full text-sm">

    @if(isset($project) && $project->images->isNotEmpty())
    <p class="mt-3 text-sm text-slate-600">Centang gambar yang ingin dihapus:</p>
    <div class="mt-2 grid grid-cols-3 gap-3 sm:grid-cols-4">
      @foreach($project->images as $img)
      <label class="block text-xs">
        <img src="{{ asset('storage/'.$img->path) }}" alt="" class="h-20 w-full border border-slate-300 object-cover">
        <input type="checkbox" name="remove_images[]" value="{{ $img->id }}" class="mt-1"> Hapus
      </label>
      @endforeach
    </div>
    @endif
  </div>

  <button class="btn-primary">Simpan</button>
</div>
