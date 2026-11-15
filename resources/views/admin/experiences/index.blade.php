@extends('layout')
@section('title', 'Kelola Pengalaman & Pendidikan')
@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Pengalaman & Pendidikan</h1>
  <a href="{{ route('admin.experiences.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">+ Tambah</a>
</div>

<div class="overflow-x-auto">
  <table class="w-full bg-white rounded-lg shadow-sm text-sm">
    <thead>
      <tr class="text-left border-b">
        <th class="p-3">Jenis</th>
        <th>Judul</th>
        <th>Instansi</th>
        <th>Periode</th>
        <th class="text-right p-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($experiences as $e)
      <tr class="border-b">
        <td class="p-3">{{ $e->type === 'work' ? 'Pengalaman' : 'Pendidikan' }}</td>
        <td>{{ $e->title }}</td>
        <td>{{ $e->organization }}</td>
        <td class="whitespace-nowrap">
          {{ $e->start_date->translatedFormat('M Y') }} - {{ $e->end_date ? $e->end_date->translatedFormat('M Y') : 'Sekarang' }}
        </td>
        <td class="p-3 text-right whitespace-nowrap">
          <a href="{{ route('admin.experiences.edit', $e) }}" class="text-indigo-600">Edit</a>
          <form method="POST" action="{{ route('admin.experiences.destroy', $e) }}" class="inline" data-confirm="Hapus data ini?">
            @csrf @method('DELETE')
            <button class="text-red-600 ml-2">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="p-3 text-slate-400">Belum ada data.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
