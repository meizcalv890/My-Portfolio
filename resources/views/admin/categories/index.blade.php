@extends('layout')
@section('title', 'Kelola Kategori')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Kelola Kategori</h1>
<form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-2 mb-6 max-w-xl">
  @csrf
  <input name="name" value="{{ old('name') }}" placeholder="Nama kategori (mis. Web App)" required maxlength="60" class="border border-slate-300 rounded-lg p-2 flex-1">
  <button class="bg-indigo-600 text-white px-4 rounded-lg">Tambah</button>
</form>
<table class="w-full bg-white rounded-lg shadow-sm text-sm">
  @forelse($categories as $c)
  <tr class="border-b">
    <td class="p-3">{{ $c->name }}</td>
    <td class="text-slate-500">{{ $c->projects_count }} proyek</td>
    <td class="p-3 text-right">
      <a href="{{ route('admin.categories.edit', $c) }}" class="text-indigo-600">Edit</a>
      <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="inline" data-confirm="Hapus kategori ini? Proyeknya tidak ikut terhapus.">
        @csrf @method('DELETE')
        <button class="text-red-600 ml-2">Hapus</button>
      </form>
    </td>
  </tr>
  @empty
  <tr>
    <td class="p-3 text-slate-400">Belum ada kategori.</td>
  </tr>
  @endforelse
</table>
@endsection
