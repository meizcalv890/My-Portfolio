@extends('layout')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Skill</h1>
<form method="POST" action="{{ route('admin.skills.update', $skill) }}" class="flex gap-2 max-w-xl">
  @csrf @method('PUT')
  <input name="name" value="{{ old('name', $skill->name) }}" class="border rounded p-2 flex-1">
  <input name="level" type="number" min="1" max="100" value="{{ old('level', $skill->level) }}" class="border rounded p-2 w-32">
  <button class="bg-indigo-600 text-white px-4 rounded">Simpan</button>
</form>
@endsection
