@csrf
<div class="space-y-3 max-w-xl">
  <div>
    <label for="type" class="text-sm text-slate-500">Jenis</label>
    <select id="type" name="type" class="w-full border border-slate-300 rounded-lg p-2">
      <option value="work" @selected(old('type', $experience->type ?? 'work') === 'work')>Pengalaman (kerja, magang, organisasi)</option>
      <option value="education" @selected(old('type', $experience->type ?? 'work') === 'education')>Pendidikan</option>
    </select>
  </div>
  <input name="title" value="{{ old('title', $experience->title ?? '') }}" placeholder="Jabatan / Jurusan (mis. Web Developer Intern)" required maxlength="150" class="w-full border border-slate-300 rounded-lg p-2">
  <input name="organization" value="{{ old('organization', $experience->organization ?? '') }}" placeholder="Perusahaan / Sekolah / Kampus" required maxlength="150" class="w-full border border-slate-300 rounded-lg p-2">
  <input name="location" value="{{ old('location', $experience->location ?? '') }}" placeholder="Lokasi (opsional)" maxlength="100" class="w-full border border-slate-300 rounded-lg p-2">
  <div class="grid grid-cols-2 gap-3">
    <div>
      <label for="start_date" class="text-sm text-slate-500">Mulai</label>
      <input id="start_date" type="date" name="start_date" value="{{ old('start_date', isset($experience) ? $experience->start_date?->format('Y-m-d') : '') }}" required class="w-full border border-slate-300 rounded-lg p-2">
    </div>
    <div>
      <label for="end_date" class="text-sm text-slate-500">Selesai (kosongkan jika masih berlangsung)</label>
      <input id="end_date" type="date" name="end_date" value="{{ old('end_date', isset($experience) ? $experience->end_date?->format('Y-m-d') : '') }}" class="w-full border border-slate-300 rounded-lg p-2">
    </div>
  </div>
  <textarea name="description" rows="5" placeholder="Deskripsi singkat: tugas dan pencapaian" maxlength="3000" class="w-full border border-slate-300 rounded-lg p-2">{{ old('description', $experience->description ?? '') }}</textarea>
  <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Simpan</button>
</div>
