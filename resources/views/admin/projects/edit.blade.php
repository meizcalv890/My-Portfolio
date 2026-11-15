@extends('layout')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Proyek</h1>
<form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
  @method('PUT')
  @include('admin.projects._form')
</form>
@endsection
