@extends('layout')
@section('title', 'Tambah Data')
@section('content')
<h1 class="mb-4 text-2xl font-semibold">Tambah Pengalaman / Pendidikan</h1>
<form method="POST" action="{{ route('admin.experiences.store') }}" enctype="multipart/form-data">
  @include('admin.experiences._form')
</form>
@endsection
