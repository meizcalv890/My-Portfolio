@extends('layout')
@section('title', 'Akun')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Ganti Password</h1>
<form method="POST" action="{{ route('admin.account.update') }}" class="space-y-3 max-w-md">
  @csrf @method('PUT')
  <div>
    <label for="current_password" class="text-sm text-slate-500">Password saat ini</label>
    <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="w-full border border-slate-300 rounded-lg p-2">
  </div>
  <div>
    <label for="password" class="text-sm text-slate-500">Password baru (min. 12 karakter, huruf besar-kecil, angka)</label>
    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full border border-slate-300 rounded-lg p-2">
  </div>
  <div>
    <label for="password_confirmation" class="text-sm text-slate-500">Ulangi password baru</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full border border-slate-300 rounded-lg p-2">
  </div>
  <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Simpan</button>
</form>
@endsection
