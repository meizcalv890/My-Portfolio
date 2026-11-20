@extends('layout')
@section('title', 'Kelola Pengalaman & Pendidikan')
@section('content')
<div class="mb-4 flex items-center justify-between">
  <h1 class="text-2xl font-semibold">Pengalaman &amp; Pendidikan</h1>
  <a href="{{ route('admin.experiences.create') }}" class="btn-primary">+ Tambah</a>
</div>

<div class="overflow-x-auto">
  <table class="w-full bg-white text-sm shadow-sm">
    <thead>
      <tr class="border-b text-left">
        <th class="p-3">Jenis</th>
        <th>Judul</th>
        <th>Instansi</th>
        <th>Periode</th>
        <th class="p-3 text-right">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($experiences as $e)
      <tr class="border-b">
        <td class="p-3">{{ $e->type === 'work' ? 'Pengalaman' : 'Pendidikan' }}</td>
        <td>{{ $e->title }}</td>
        <td>{{ $e->organization }}</td>
        <td class="whitespace-nowrap">{{ $e->start_date->format('Y') }} &ndash; {{ $e->end_date ? $e->end_date->format('Y') : 'Sekarang' }}</td>
        <td class="whitespace-nowrap p-3 text-right">
          <a href="{{ route('admin.experiences.edit', $e) }}" class="text-indigo-600">Edit</a>
          <form method="POST" action="{{ route('admin.experiences.destroy', $e) }}" class="inline" data-confirm="Hapus data ini?">
            @csrf @method('DELETE')
            <button class="ml-2 text-red-600">Hapus</button>
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
