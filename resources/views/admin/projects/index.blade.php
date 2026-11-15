@extends('layout')
@section('title', 'Kelola Proyek')
@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Kelola Proyek</h1>
  <a href="{{ route('admin.projects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">+ Tambah</a>
</div>

<div class="overflow-x-auto">
  <table class="w-full bg-white rounded-lg shadow-sm text-sm">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">Judul</th>
        <th>Kategori</th>
        <th>Tech</th>
        <th class="text-right p-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($projects as $p)
      <tr class="border-b">
        <td class="p-3">{{ $p->title }}</td>
        <td>{{ $p->category->name ?? '-' }}</td>
        <td>{{ $p->tech_stack }}</td>
        <td class="p-3 text-right whitespace-nowrap">
          <a href="{{ route('admin.projects.edit', $p) }}" class="text-indigo-600">Edit</a>
          <form method="POST" action="{{ route('admin.projects.destroy', $p) }}" class="inline" data-confirm="Hapus proyek ini?">
            @csrf @method('DELETE')
            <button class="text-red-600 ml-2">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="p-3 text-slate-400">Belum ada data.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
