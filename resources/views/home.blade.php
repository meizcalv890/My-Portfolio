@extends('layout')
@section('title', $profile->name . ' | Portofolio')
@section('description', $profile->headline ?: 'Portofolio ' . $profile->name)
@section('content')

{{-- HERO --}}
<section class="pb-16 pt-10 md:pb-24 md:pt-16">
  <div class="grid items-end gap-12 md:grid-cols-12">
    <div class="md:col-span-8">
      <p class="kicker rise inline-flex items-center gap-2">
        <span class="h-2 w-2 rounded-full bg-ink" aria-hidden="true"></span> Portofolio {{ date('Y') }}
      </p>
      <h1 class="mt-6 text-6xl font-semibold leading-[0.92] tracking-tighter sm:text-7xl md:text-8xl">
        @foreach(preg_split('/\s+/', trim($profile->name)) as $i => $word)
        <span class="word"><span style="--d: {{ $i * 0.09 }}s">{{ $word }}</span></span>
        @endforeach
      </h1>
      @if($profile->headline)
      <p class="rise rise-3 mt-6 max-w-xl text-xl text-muted md:text-2xl">{{ $profile->headline }}</p>
      @endif

      <div class="rise rise-3 mt-10 flex flex-wrap items-center gap-3">
        <a href="#proyek" class="btn-primary">Lihat karya &darr;</a>
        @if($profile->cv)
        <a href="{{ asset('storage/'.$profile->cv) }}" target="_blank" rel="noopener" class="btn-outline">Unduh CV</a>
        @endif
        <a href="#kontak" class="btn text-ink underline underline-offset-4 hover:no-underline">Hubungi saya</a>
      </div>
    </div>

    <div class="rise rise-2 mx-auto w-full max-w-xs md:col-span-4 md:mx-0 md:max-w-none">
      <div data-tilt class="tilt">
        @if($profile->photo)
        <img src="{{ asset('storage/'.$profile->photo) }}" alt="Foto {{ $profile->name }}" class="aspect-[3/4] w-full border border-line object-cover">
        @else
        <div class="grid aspect-[3/4] w-full place-items-center border border-line bg-paper-2 text-8xl font-semibold text-muted/50" aria-hidden="true">{{ str($profile->name)->substr(0, 1)->upper() }}</div>
        @endif
      </div>
    </div>
  </div>

  {{-- Strip info --}}
  @php
  $hasLinks = $profile->github || $profile->linkedin || $profile->instagram;
  @endphp
  <dl class="reveal mt-16 grid divide-y divide-line border-y border-ink md:grid-cols-3 md:divide-x md:divide-y-0">
    <div class="py-5 md:pr-6">
      <dt class="label">Status</dt>
      <dd class="mt-2">
        @if($profile->availability)
        {{ $profile->availability }}
        @else
        @auth <span class="text-muted">Isi di Admin &rarr; Profil</span> @else &mdash; @endauth
        @endif
      </dd>
    </div>
    <div class="py-5 md:px-6">
      <dt class="label">Kontak</dt>
      <dd class="mt-2 break-all">
        @if($profile->email)
        <a href="mailto:{{ $profile->email }}" class="underline underline-offset-4 hover:no-underline">{{ $profile->email }}</a>
        @else
        &mdash;
        @endif
      </dd>
    </div>
    <div class="py-5 md:pl-6">
      <dt class="label">Tautan</dt>
      <dd class="mt-2 flex flex-wrap gap-x-4 gap-y-1">
        @if($profile->github)<a href="{{ $profile->github }}" target="_blank" rel="noopener noreferrer" class="underline underline-offset-4 hover:no-underline">GitHub</a>@endif
        @if($profile->linkedin)<a href="{{ $profile->linkedin }}" target="_blank" rel="noopener noreferrer" class="underline underline-offset-4 hover:no-underline">LinkedIn</a>@endif
        @if($profile->instagram)<a href="{{ $profile->instagram }}" target="_blank" rel="noopener noreferrer" class="underline underline-offset-4 hover:no-underline">Instagram</a>@endif
        @unless($hasLinks)&mdash;@endunless
      </dd>
    </div>
  </dl>
</section>

{{-- 01 PROYEK --}}
<section id="proyek" class="scroll-mt-20 py-16">
  <div class="reveal flex flex-wrap items-end justify-between gap-6">
    <div>
      <p class="kicker">01 / Karya</p>
      <h2 class="section-title mt-3">Karya terpilih</h2>
    </div>
    <form method="GET" action="{{ route('home') }}#proyek" class="flex w-full items-end gap-3 sm:w-72">
      @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
      <label for="q" class="sr-only">Cari proyek</label>
      <input id="q" name="q" value="{{ request('q') }}" placeholder="Cari judul / teknologi" class="input">
      <button class="font-mono text-xs uppercase tracking-widest hover:underline">Cari</button>
    </form>
  </div>

  @if($categories->isNotEmpty())
  <div class="mt-8 flex flex-wrap gap-2 text-sm">
    <a href="{{ route('home', ['q' => request('q')]) }}#proyek"
      class="rounded-full border px-4 py-1.5 transition {{ request('category') ? 'border-line hover:border-ink' : 'border-ink bg-ink text-white' }}">Semua</a>
    @foreach($categories as $c)
    <a href="{{ route('home', ['category' => $c->slug, 'q' => request('q')]) }}#proyek"
      class="rounded-full border px-4 py-1.5 transition {{ request('category') === $c->slug ? 'border-ink bg-ink text-white' : 'border-line hover:border-ink' }}">{{ $c->name }}</a>
    @endforeach
  </div>
  @endif

  <div class="mt-10 grid gap-x-8 gap-y-14 md:grid-cols-2">
    @forelse($projects as $p)
    <a href="{{ route('projects.show', $p) }}" class="reveal group block" style="--d: {{ ($loop->index % 2) * 0.1 }}s">
      <div data-cursor="Lihat" class="aspect-[16/10] overflow-hidden border border-line bg-paper-2">
        @if($p->image)
        <img src="{{ asset('storage/'.$p->image) }}" alt="Cuplikan proyek {{ $p->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]">
        @else
        <div class="grid h-full place-items-center text-6xl font-semibold text-muted/40" aria-hidden="true">{{ str($p->title)->substr(0, 1)->upper() }}</div>
        @endif
      </div>

      <div class="mt-4 flex items-start justify-between gap-4">
        <div>
          <h3 class="text-2xl font-semibold tracking-tight underline-offset-4 group-hover:underline">{{ $p->title }}</h3>
          <p class="mt-1 text-muted">{{ \Illuminate\Support\Str::limit($p->description, 100) }}</p>
        </div>
        <span class="font-mono text-xs text-muted">{{ str($projects->firstItem() + $loop->index)->padLeft(2, '0') }}</span>
      </div>

      <div class="mt-3 flex flex-wrap items-center gap-1.5">
        @if($p->category)<span class="tag border-ink text-ink">{{ $p->category->name }}</span>@endif
        @if($p->year)<span class="tag">{{ $p->year }}</span>@endif
        @if($p->tech_stack)
        @foreach(array_slice(array_filter(array_map('trim', explode(',', $p->tech_stack))), 0, 3) as $tech)
        <span class="tag">{{ $tech }}</span>
        @endforeach
        @endif
      </div>
    </a>
    @empty
    <div class="border border-dashed border-line p-12 text-center text-muted md:col-span-2">
      {{ request()->hasAny(['q', 'category']) ? 'Proyek tidak ditemukan.' : 'Belum ada proyek untuk ditampilkan.' }}
    </div>
    @endforelse
  </div>

  <div class="mt-10">{{ $projects->fragment('proyek')->links() }}</div>
</section>

{{-- 02 TENTANG --}}
<section id="tentang" class="scroll-mt-20 border-t border-line py-16">
  <div class="grid gap-8 md:grid-cols-12">
    <div class="reveal md:col-span-4">
      <p class="kicker">02 / Tentang</p>
      <h2 class="section-title mt-3">Sedikit tentang saya</h2>
    </div>
    <div class="reveal md:col-span-8" style="--d: .1s">
      @if($profile->about)
      <p class="whitespace-pre-line text-xl leading-relaxed md:text-2xl">{{ $profile->about }}</p>
      @else
      <div class="border border-dashed border-line p-8 text-muted">
        @auth Isi "Tentang saya" di Admin &rarr; Profil. @else Belum ada deskripsi. @endauth
      </div>
      @endif
    </div>
  </div>
</section>

{{-- 03 SKILL --}}
@php
$groups = collect([
'Sehari-hari' => $skills->where('level', '>=', 70),
'Cukup nyaman' => $skills->where('level', '>=', 40)->where('level', '<', 70), 'Sedang saya pelajari'=> $skills->where('level', '<', 40),
    ])->filter(fn ($g) => $g->isNotEmpty());
    @endphp
    <section id="skill" class="scroll-mt-20 border-t border-line py-16">
      <div class="reveal">
        <p class="kicker">03 / Skill</p>
        <h2 class="section-title mt-3">Perangkat saya</h2>
      </div>

      @forelse($groups as $label => $items)
      <div class="mt-10">
        <h3 class="label !font-mono">{{ $label }} <span class="text-muted/60">({{ $items->count() }})</span></h3>
        <ul class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
          @foreach($items as $s)
          <li class="reveal" style="--d: {{ ($loop->index % 4) * 0.07 }}s">
            <div class="skill-tile flex items-center gap-4 border border-line bg-white p-4 transition duration-300 hover:-translate-y-1 hover:border-ink hover:shadow-lg">
              <span class="grid h-12 w-12 shrink-0 place-items-center bg-paper-2">
                @if($s->logo_url)
                <img src="{{ $s->logo_url }}" alt="" loading="lazy" data-fallback class="logo-img h-7 w-7 object-contain">
                @endif
                <span class="logo-letter text-lg font-semibold text-muted {{ $s->logo_url ? 'hidden' : '' }}" aria-hidden="true">{{ str($s->name)->substr(0, 1)->upper() }}</span>
              </span>
              <span class="font-medium">{{ $s->name }}</span>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
      @empty
      <div class="mt-10 border border-dashed border-line p-12 text-center text-muted">Belum ada skill.</div>
      @endforelse
    </section>

    {{-- 04 PENGALAMAN --}}
    @if($experiences->isNotEmpty())
    <section id="pengalaman" class="scroll-mt-20 border-t border-line py-16">
      <div class="reveal">
        <p class="kicker">04 / Perjalanan</p>
        <h2 class="section-title mt-3">Pengalaman &amp; pendidikan</h2>
      </div>

      @foreach(['work' => 'Pengalaman', 'education' => 'Pendidikan'] as $type => $label)
      @php
      $items = $experiences->where('type', $type);
      @endphp
      @if($items->isNotEmpty())
      <div class="mt-12">
        <h3 class="label !font-mono">{{ $label }}</h3>
        <ol class="mt-4 border-t border-ink">
          @foreach($items as $e)
          <li class="reveal grid gap-3 border-b border-line py-6 md:grid-cols-12">
            <p class="font-mono text-sm text-muted md:col-span-3">
              {{ $e->start_date->translatedFormat('M Y') }} &ndash; {{ $e->end_date ? $e->end_date->translatedFormat('M Y') : 'Sekarang' }}
            </p>
            <div class="flex gap-5 md:col-span-9">
              @if($e->photo)
              <button type="button" data-zoom="{{ asset('storage/'.$e->photo) }}" aria-label="Perbesar foto {{ $e->title }}"
                class="h-20 w-20 shrink-0 cursor-zoom-in overflow-hidden border border-line">
                <img src="{{ asset('storage/'.$e->photo) }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-300 hover:scale-110">
              </button>
              @endif
              <div>
                <h4 class="text-xl font-semibold">{{ $e->title }}</h4>
                <p class="text-muted">{{ $e->organization }}@if($e->location), {{ $e->location }}@endif</p>
                @if($e->description)
                <p class="mt-3 max-w-2xl whitespace-pre-line leading-relaxed">{{ $e->description }}</p>
                @endif
              </div>
            </div>
          </li>
          @endforeach
        </ol>
      </div>
      @endif
      @endforeach
    </section>
    @endif

    {{-- 05 KONTAK (blok hitam) --}}
    <section id="kontak" class="scroll-mt-20 py-16">
      <div class="reveal bg-ink p-8 text-white md:p-14">
        <div class="grid gap-12 md:grid-cols-12">
          <div class="md:col-span-6">
            <p class="kicker text-white/60">05 / Kontak</p>
            <h2 class="section-title mt-3">Tertarik bekerja sama? Tulis saja.</h2>
            <p class="mt-6 max-w-md text-lg text-white/70">Kirim pesan lewat formulir ini, atau langsung ke email saya.</p>
            @if($profile->email)
            <a href="mailto:{{ $profile->email }}" class="mt-8 inline-block break-all text-2xl font-medium underline decoration-white/40 underline-offset-8 hover:decoration-white">{{ $profile->email }}</a>
            @endif
          </div>

          <form method="POST" action="{{ route('contact') }}" class="space-y-6 md:col-span-6">
            @csrf
            <div class="hidden" aria-hidden="true">
              <label for="website">Website</label>
              <input id="website" name="website" tabindex="-1" autocomplete="off">
            </div>
            <div>
              <label for="name" class="label text-white/60">Nama</label>
              <input id="name" name="name" value="{{ old('name') }}" required maxlength="100" class="input">
            </div>
            <div>
              <label for="email" class="label text-white/60">Email</label>
              <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="150" class="input">
            </div>
            <div>
              <label for="body" class="label text-white/60">Pesan</label>
              <textarea id="body" name="body" rows="4" required maxlength="2000" class="input resize-y">{{ old('body') }}</textarea>
            </div>
            <button class="btn bg-white text-ink hover:bg-neutral-200">Kirim pesan &rarr;</button>
          </form>
        </div>
      </div>
    </section>
    @endsection
