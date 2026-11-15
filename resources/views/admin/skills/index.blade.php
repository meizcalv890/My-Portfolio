@extends('layout')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Kelola Skill</h1>
<form method="POST" action="{{ route('admin.skills.store') }}" class="flex gap-2 mb-6">
  @csrf
  <input name="name" placeholder="Nama skill" class="border rounded p-2 flex-1">
  <input name="level" type="number" min="1" max="100" placeholder="Level (1-100)" class="border rounded p-2 w-40">
  <button class="bg-indigo-600 text-white px-4 rounded">Tambah</button>
</form>
<table class="w-full bg-white rounded shadow text-sm">
  @forelse($skills as $s)
  <tr class="border-b">
    <td class="p-3">{{ $s->name }}</td>
    <td>{{ $s->level }}%</td>
    <td class="p-3 text-right">
      <a href="{{ route('admin.skills.edit', $s) }}" class="text-indigo-600">Edit</a>
      <form method="POST" action="{{ route('admin.skills.destroy', $s) }}" class="inline" data-confirm="Hapus?">
        @csrf @method('DELETE')
        <button class="text-red-600 ml-2">Hapus</button>
      </form>
    </td>
  </tr>
  @empty
  <tr>
    <td class="p-3 text-slate-400">Belum ada skill.</td>
  </tr>
  @endforelse
</table>
@endsection
