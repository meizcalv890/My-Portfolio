@extends('layout')
@section('title', 'Edit Kategori')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Kategori</h1>
<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="flex gap-2 max-w-xl">
  @csrf @method('PUT')
  <input name="name" value="{{ old('name', $category->name) }}" required maxlength="60" class="border border-slate-300 rounded-lg p-2 flex-1">
  <button class="bg-indigo-600 text-white px-4 rounded-lg">Simpan</button>
</form>
@endsection
