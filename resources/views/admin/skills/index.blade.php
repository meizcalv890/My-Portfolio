@extends('layout')
@section('title', 'Kelola Skill')
@section('content')
<h1 class="mb-4 text-2xl font-semibold">Kelola Skill</h1>

<form method="POST" action="{{ route('admin.skills.store') }}" enctype="multipart/form-data" class="mb-8 grid max-w-3xl gap-4 border border-line bg-white p-5 sm:grid-cols-2">
  @csrf
  <div>
    <label for="name" class="label">Nama skill</label>
    <input id="name" name="name" value="{{ old('name') }}" required maxlength="80" class="field">
  </div>
  <div>
    <label for="level" class="label">Level (1-100)</label>
    <input id="level" type="number" name="level" min="1" max="100" value="{{ old('level') }}" required class="field">
    <p class="mt-1 text-xs text-slate-500">70+ = Sehari-hari, 40-69 = Cukup nyaman, di bawah 40 = Sedang dipelajari.</p>
  </div>
  <div>
    <label for="icon_slug" class="label">Logo dari Devicon (kode)</label>
    <input id="icon_slug" name="icon_slug" value="{{ old('icon_slug') }}" placeholder="laravel" maxlength="60" class="field">
    <p class="mt-1 text-xs text-slate-500">Contoh: laravel, php, mysql, javascript, html5, css3, tailwindcss, git. Daftar kode ada di devicon.dev.</p>
  </div>
  <div>
    <label for="icon" class="label">Atau unggah logo sendiri (PNG/JPG/WebP, maks 1MB)</label>
    <input id="icon" type="file" name="icon" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full text-sm">
    <p class="mt-1 text-xs text-slate-500">Kalau keduanya diisi, logo unggahan yang dipakai.</p>
  </div>
  <div class="sm:col-span-2">
    <button class="btn-primary">Tambah</button>
  </div>
</form>

<div class="overflow-x-auto">
  <table class="w-full bg-white text-sm shadow-sm">
    @forelse($skills as $s)
    <tr class="border-b">
      <td class="w-14 p-3">
        @if($s->logo_url)
        <img src="{{ $s->logo_url }}" alt="" class="h-7 w-7 object-contain">
        @endif
      </td>
      <td class="p-3 font-medium">{{ $s->name }}</td>
      <td class="p-3 text-slate-500">{{ $s->level }}%</td>
      <td class="whitespace-nowrap p-3 text-right">
        <a href="{{ route('admin.skills.edit', $s) }}" class="text-indigo-600">Edit</a>
        <form method="POST" action="{{ route('admin.skills.destroy', $s) }}" class="inline" data-confirm="Hapus skill ini?">
          @csrf @method('DELETE')
          <button class="ml-2 text-red-600">Hapus</button>
        </form>
      </td>
    </tr>
    @empty
    <tr>
      <td class="p-3 text-slate-400">Belum ada skill.</td>
    </tr>
    @endforelse
  </table>
</div>
@endsection
