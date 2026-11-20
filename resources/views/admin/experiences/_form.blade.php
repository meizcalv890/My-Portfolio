@csrf
<div class="max-w-xl space-y-4">
  <div>
    <label for="type" class="label">Jenis</label>
    <select id="type" name="type" class="field">
      <option value="work" @selected(old('type', $experience->type ?? 'work') === 'work')>Pengalaman (kerja, magang, organisasi)</option>
      <option value="education" @selected(old('type', $experience->type ?? 'work') === 'education')>Pendidikan</option>
    </select>
  </div>
  <div>
    <label for="title" class="label">Jabatan / Jurusan</label>
    <input id="title" name="title" value="{{ old('title', $experience->title ?? '') }}" required maxlength="150" class="field">
  </div>
  <div>
    <label for="organization" class="label">Perusahaan / Sekolah / Kampus</label>
    <input id="organization" name="organization" value="{{ old('organization', $experience->organization ?? '') }}" required maxlength="150" class="field">
  </div>
  <div>
    <label for="location" class="label">Lokasi (opsional)</label>
    <input id="location" name="location" value="{{ old('location', $experience->location ?? '') }}" maxlength="100" class="field">
  </div>
  <div class="grid grid-cols-2 gap-3">
    <div>
      <label for="start_year" class="label">Tahun mulai</label>
      <input id="start_year" type="number" name="start_year" min="1950" max="{{ now()->year + 1 }}" placeholder="2023" required
        value="{{ old('start_year', isset($experience) ? $experience->start_date?->format('Y') : '') }}" class="field">
    </div>
    <div>
      <label for="end_year" class="label">Tahun selesai (kosong = masih berlangsung)</label>
      <input id="end_year" type="number" name="end_year" min="1950" max="{{ now()->year + 1 }}" placeholder="2025"
        value="{{ old('end_year', isset($experience) ? $experience->end_date?->format('Y') : '') }}" class="field">
    </div>
  </div>
  <div>
    <label for="description" class="label">Deskripsi singkat</label>
    <textarea id="description" name="description" rows="5" maxlength="3000" class="field">{{ old('description', $experience->description ?? '') }}</textarea>
  </div>
  <div>
    <label for="photo" class="label">Foto atau logo instansi (opsional, maks 2MB)</label>
    <input id="photo" type="file" name="photo" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full text-sm">
    @if(!empty($experience->photo))
    <img src="{{ asset('storage/'.$experience->photo) }}" alt="" class="mt-2 h-20 w-20 border border-slate-300 object-cover">
    <label class="mt-2 block text-xs"><input type="checkbox" name="remove_photo" value="1"> Hapus foto ini</label>
    @endif
  </div>
  <button class="btn-primary">Simpan</button>
</div>
