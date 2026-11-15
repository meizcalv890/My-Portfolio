@extends('layout')
@section('title', 'Edit Data')
@section('content')
<h1 class="mb-4 text-2xl font-semibold">Edit Pengalaman / Pendidikan</h1>
<form method="POST" action="{{ route('admin.experiences.update', $experience) }}" enctype="multipart/form-data">
  @method('PUT')
  @include('admin.experiences._form')
</form>
@endsection
