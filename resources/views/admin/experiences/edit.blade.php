@extends('layout')
@section('title', 'Edit Data')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Pengalaman / Pendidikan</h1>
<form method="POST" action="{{ route('admin.experiences.update', $experience) }}">
  @method('PUT')
  @include('admin.experiences._form')
</form>
@endsection
