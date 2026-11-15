@extends('layout')
@section('title', 'Edit Skill')
@section('content')
<h1 class="mb-4 text-2xl font-semibold">Edit Skill</h1>

<form method="POST" action="{{ route('admin.skills.update', $skill) }}" enctype="multipart/form-data" class="grid max-w-3xl gap-4 border border-line bg-white p-5 sm:grid-cols-2">
  @csrf @method('PUT')
  <div>
    <label for="name" class="label">Nama skill</label>
    <input id="name" name="name" value="{{ old('name', $skill->name) }}" required maxlength="80" class="field">
  </div>
  <div>
    <label for="level" class="label">Level (1-100)</label>
    <input id="level" type="number" name="level" min="1" max="100" value="{{ old('level', $skill->level) }}" required class="field">
  </div>
  <div>
    <label for="icon_slug" class="label">Logo dari Devicon (kode)</label>
    <input id="icon_slug" name="icon_slug" value="{{ old('icon_slug', $skill->icon_slug) }}" placeholder="laravel" maxlength="60" class="field">
  </div>
  <div>
    <label for="icon" class="label">Unggah logo sendiri (maks 1MB)</label>
    <input id="icon" type="file" name="icon" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full text-sm">
    @if($skill->icon)
    <img src="{{ asset('storage/'.$skill->icon) }}" alt="" class="mt-2 h-10 w-10 object-contain">
    <label class="mt-2 block text-xs"><input type="checkbox" name="remove_icon" value="1"> Hapus logo unggahan</label>
    @endif
  </div>
  <div class="sm:col-span-2">
    <button class="btn-primary">Simpan</button>
  </div>
</form>
@endsection
