@extends('layout')
@section('title', 'Tambah Data')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Tambah Pengalaman / Pendidikan</h1>
<form method="POST" action="{{ route('admin.experiences.store') }}">
  @include('admin.experiences._form')
</form>
@endsection
