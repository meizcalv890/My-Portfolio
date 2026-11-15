@extends('layout')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Tambah Proyek</h1>
<form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
  @include('admin.projects._form')
</form>
@endsection
