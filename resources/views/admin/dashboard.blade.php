@extends('layout')
@section('title', 'Dashboard')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Dashboard</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
  <div class="bg-white p-4 rounded shadow">
    <p class="text-sm text-slate-500">Proyek</p>
    <p class="text-3xl font-bold">{{ $projectCount }}</p>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <p class="text-sm text-slate-500">Skill</p>
    <p class="text-3xl font-bold">{{ $skillCount }}</p>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <p class="text-sm text-slate-500">Pesan</p>
    <p class="text-3xl font-bold">{{ $messageCount }}</p>
  </div>
  <div class="bg-white p-4 rounded shadow">
    <p class="text-sm text-slate-500">Belum dibaca</p>
    <p class="text-3xl font-bold text-red-600">{{ $unread }}</p>
  </div>
</div>

<h2 class="text-lg font-semibold mb-3">Pesan Terbaru</h2>
@forelse($latest as $m)
<div class="bg-white p-3 rounded shadow mb-2 text-sm">
  <strong>{{ $m->name }}</strong>
  @unless($m->is_read)<span class="ml-2 text-xs bg-red-100 text-red-700 px-2 rounded">baru</span>@endunless
  <p class="text-slate-600">{{ \Illuminate\Support\Str::limit($m->body, 100) }}</p>
</div>
@empty
<p class="text-slate-400">Belum ada pesan.</p>
@endforelse
@endsection
