<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name'))</title>
  <meta name="description" content="@yield('description', 'Portofolio web developer: proyek, skill, dan kontak.')">
  <meta property="og:title" content="@yield('title', config('app.name'))">
  <meta property="og:description" content="@yield('description', 'Portofolio web developer: proyek, skill, dan kontak.')">
  <meta name="theme-color" content="#ffffff">
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%230a0a0a'/%3E%3Ctext x='50' y='72' font-size='62' text-anchor='middle' fill='white' font-family='Arial,sans-serif' font-weight='bold'%3EM%3C/text%3E%3C/svg%3E">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen">
  @php
  $links = [
  ['Proyek', route('home') . '#proyek'],
  ['Tentang', route('home') . '#tentang'],
  ['Skill', route('home') . '#skill'],
  ['Pengalaman', route('home') . '#pengalaman'],
  ['Kontak', route('home') . '#kontak'],
  ];
  @endphp

  @auth
  <div class="bg-ink text-sm text-white">
    <div class="mx-auto flex max-w-6xl items-center gap-5 overflow-x-auto whitespace-nowrap px-5 py-2">
      <span class="font-mono text-xs uppercase tracking-widest text-white/50">Admin</span>
      <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
      <a href="{{ route('admin.profile.edit') }}" class="hover:underline">Profil</a>
      <a href="{{ route('admin.projects.index') }}" class="hover:underline">Proyek</a>
      <a href="{{ route('admin.categories.index') }}" class="hover:underline">Kategori</a>
      <a href="{{ route('admin.skills.index') }}" class="hover:underline">Skill</a>
      <a href="{{ route('admin.experiences.index') }}" class="hover:underline">Pengalaman</a>
      <a href="{{ route('admin.messages.index') }}" class="hover:underline">Pesan</a>
      <a href="{{ route('admin.account.edit') }}" class="hover:underline">Akun</a>
      <form method="POST" action="{{ route('logout') }}" class="ml-auto">@csrf
        <button class="text-red-300 hover:underline">Logout</button>
      </form>
    </div>
  </div>
  @endauth

  <header class="sticky top-0 z-30 border-b border-line bg-white/85 backdrop-blur">
    <div class="mx-auto flex h-14 max-w-6xl items-center justify-between px-5">
      <a href="{{ route('home') }}" class="text-base font-semibold tracking-tight">{{ config('app.name') }}</a>

      <nav class="hidden items-center gap-7 md:flex" aria-label="Navigasi utama">
        @foreach($links as [$label, $href])
        <a href="{{ $href }}" data-nav class="nav-link">{{ $label }}</a>
        @endforeach
        @guest
        <a href="{{ route('login') }}" class="nav-link opacity-50">Admin</a>
        @endguest
      </nav>

      <button id="menu-btn" class="p-2 md:hidden" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="square" d="M4 7h16M4 12h16M4 17h16" />
        </svg>
      </button>
    </div>

    <nav id="mobile-menu" class="hidden border-t border-line bg-white px-5 py-2 md:hidden" aria-label="Navigasi mobile">
      @foreach($links as [$label, $href])
      <a href="{{ $href }}" class="block border-b border-line py-3 text-lg font-medium">{{ $label }}</a>
      @endforeach
      @guest
      <a href="{{ route('login') }}" class="block py-3 text-muted">Admin</a>
      @endguest
    </nav>
  </header>

  <main class="mx-auto max-w-6xl px-5 py-8">
    @if(session('success'))
    <div class="mb-6 border-l-4 border-ink bg-paper-2 p-3 text-sm" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="mb-6 border-l-4 border-red-700 bg-red-50 p-3 text-sm text-red-900" role="alert">
      <ul class="ml-5 list-disc">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif
    @yield('content')
  </main>

  <footer class="mt-24 border-t border-line">
    <div class="mx-auto flex max-w-6xl flex-col justify-between gap-3 px-5 py-8 font-mono text-xs uppercase tracking-widest text-muted sm:flex-row">
      <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
      <p>Laravel &middot; MySQL &middot; Tailwind</p>
      <a href="#" class="hover:text-ink">Ke atas &uarr;</a>
    </div>
  </footer>
</body>

</html>
