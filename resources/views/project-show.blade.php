@extends('layout')
@section('title', $project->title)
@section('description', \Illuminate\Support\Str::limit($project->description, 150))
@section('content')
<article class="mx-auto max-w-5xl">
  <a href="{{ route('home') }}#proyek" class="font-mono text-xs uppercase tracking-widest hover:text-accent">&larr; Semua karya</a>

  <header class="mt-10 border-b border-ink pb-10">
    @if($project->category)<p class="kicker">{{ $project->category->name }}</p>@endif
    <h1 class="mt-3 font-serif text-5xl font-semibold leading-[1.02] tracking-tight text-balance md:text-7xl">{{ $project->title }}</h1>

    <dl class="mt-10 grid grid-cols-2 gap-6 md:grid-cols-4">
      <div>
        <dt class="label">Peran</dt>
        <dd class="mt-1">{{ $project->role ?: '-' }}</dd>
      </div>
      <div>
        <dt class="label">Tahun</dt>
        <dd class="mt-1">{{ $project->year ?: '-' }}</dd>
      </div>
      <div class="col-span-2">
        <dt class="label">Teknologi</dt>
        <dd class="mt-1 flex flex-wrap gap-1.5">
          @forelse(array_filter(array_map('trim', explode(',', (string) $project->tech_stack))) as $tech)
          <span class="tag">{{ $tech }}</span>
          @empty
          -
          @endforelse
        </dd>
      </div>
    </dl>

    @if($project->url || $project->repo_url)
    <div class="mt-8 flex flex-wrap gap-3">
      @if($project->url)<a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer" class="btn-primary">Lihat demo &nearr;</a>@endif
      @if($project->repo_url)<a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer" class="btn-outline">Repository &nearr;</a>@endif
    </div>
    @endif
  </header>

  @if($project->image)
  <img src="{{ asset('storage/'.$project->image) }}" alt="Cuplikan proyek {{ $project->title }}" class="mt-10 aspect-video w-full border border-ink object-cover">
  @endif

  <div class="mt-6">
    @foreach([['Ringkasan', $project->description], ['Masalah', $project->problem], ['Hasil', $project->result]] as [$label, $text])
    @if($text)
    <section class="grid gap-3 border-t border-line py-8 md:grid-cols-12">
      <h2 class="label !font-mono md:col-span-3">{{ $label }}</h2>
      <p class="whitespace-pre-line text-lg leading-relaxed md:col-span-9">{{ $text }}</p>
    </section>
    @endif
    @endforeach
  </div>

  @if($project->images->isNotEmpty())
  <section class="mt-6 border-t border-ink pt-6">
    <h2 class="label !font-mono">Galeri</h2>
    <div class="mt-4 grid gap-4 md:grid-cols-2">
      @foreach($project->images as $img)
      <a href="{{ asset('storage/'.$img->path) }}" target="_blank" rel="noopener"
        class="{{ $loop->first && $project->images->count() % 2 === 1 ? 'md:col-span-2' : '' }} block overflow-hidden border border-ink bg-paper-2">
        <img src="{{ asset('storage/'.$img->path) }}" alt="Cuplikan {{ $loop->iteration }} dari {{ $project->title }}" loading="lazy" class="w-full">
      </a>
      @endforeach
    </div>
  </section>
  @endif
</article>
@endsection
