@extends('layout')
@section('title', 'Pesan Masuk')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Pesan Masuk</h1>
@forelse($messages as $m)
<div class="bg-white p-4 rounded-lg shadow-sm mb-3 {{ $m->is_read ? '' : 'border-l-4 border-indigo-500' }}">
  <div class="flex justify-between gap-3">
    <div>
      <strong>{{ $m->name }}</strong>
      <span class="text-slate-500 text-sm">&lt;{{ $m->email }}&gt;</span>
      @unless($m->is_read)<span class="ml-2 text-xs bg-red-100 text-red-700 px-2 rounded">baru</span>@endunless
    </div>
    <div class="flex gap-3 text-sm">
      @unless($m->is_read)
      <form method="POST" action="{{ route('admin.messages.read', $m) }}">
        @csrf @method('PATCH')
        <button class="text-indigo-600">Tandai dibaca</button>
      </form>
      @endunless
      <form method="POST" action="{{ route('admin.messages.destroy', $m) }}" data-confirm="Hapus pesan ini?">
        @csrf @method('DELETE')
        <button class="text-red-600">Hapus</button>
      </form>
    </div>
  </div>
  <p class="mt-2 whitespace-pre-line">{{ $m->body }}</p>
  <p class="text-xs text-slate-400 mt-2">{{ $m->created_at->format('d M Y H:i') }}</p>
</div>
@empty
<p class="text-slate-400">Belum ada pesan.</p>
@endforelse

<div class="mt-4">{{ $messages->links() }}</div>
@endsection
