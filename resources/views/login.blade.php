@extends('layout')
@section('title', 'Login Admin')
@section('content')
<div class="mx-auto mt-10 max-w-sm border border-ink bg-white p-8">
  <h1 class="font-serif text-3xl font-semibold">Masuk</h1>
  <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-6">
    @csrf
    <div>
      <label for="email" class="label">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="input">
    </div>
    <div>
      <label for="password" class="label">Password</label>
      <input id="password" type="password" name="password" required autocomplete="current-password" class="input">
    </div>
    <button class="btn-primary w-full">Masuk</button>
  </form>
</div>
@endsection
