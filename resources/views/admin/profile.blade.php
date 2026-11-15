@extends('layout')
@section('title', 'Edit Profil')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Profil</h1>
<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-3 max-w-xl">
  @csrf @method('PUT')
  <input name="name" value="{{ old('name', $profile->name) }}" placeholder="Nama" class="w-full border rounded p-2">
  <input name="headline" value="{{ old('headline', $profile->headline) }}" placeholder="Headline (mis. Mahasiswa Informatika | Web Developer)" class="w-full border rounded p-2">
  <input name="availability" value="{{ old('availability', $profile->availability) }}" placeholder="Status ketersediaan (mis. Mencari magang Web Developer mulai Januari 2027)" maxlength="200" class="w-full border border-slate-300 rounded-lg p-2">
  <textarea name="about" rows="6" placeholder="Tentang saya" class="w-full border rounded p-2">{{ old('about', $profile->about) }}</textarea>
  <input name="email" value="{{ old('email', $profile->email) }}" placeholder="Email publik" class="w-full border rounded p-2">
  <input name="github" value="{{ old('github', $profile->github) }}" placeholder="URL GitHub (https://...)" class="w-full border rounded p-2">
  <input name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="URL LinkedIn (https://...)" class="w-full border rounded p-2">
  <input name="instagram" value="{{ old('instagram', $profile->instagram) }}" placeholder="URL Instagram (https://...)" class="w-full border rounded p-2">

  <div>
    <label class="text-sm text-slate-500">Foto profil (maks 2MB)</label>
    <input type="file" name="photo" class="w-full">
    @if($profile->photo)<img src="{{ asset('storage/'.$profile->photo) }}" class="h-24 mt-2 rounded-full">@endif
  </div>
  <div>
    <label class="text-sm text-slate-500">CV (PDF, maks 5MB)</label>
    <input type="file" name="cv" class="w-full">
    @if($profile->cv)<a href="{{ asset('storage/'.$profile->cv) }}" target="_blank" class="text-indigo-600 text-sm">CV saat ini</a>@endif
  </div>
  <button class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
