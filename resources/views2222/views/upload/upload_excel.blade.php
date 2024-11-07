@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <form action="{{ route('uploadFile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Archivo:</label>
        <input class="form-control" type="file" name="file" id="file" required>

        <button class="btn btn-success mt-3" type="submit">Subir</button>
    </form>

@endsection