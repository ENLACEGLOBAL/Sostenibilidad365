@extends('layouts.app')

@section('content')

    <div class="container">
    <a href="{{route("home")}}"><button type="button" class="btn btn-dark">Volver</button></a>
        <div class="card">
            <div class="card-header">Crear Empresa</div>
            <div class="card-body">
                <form action="{{route('create_company')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="mb-3">
                    <label for="razon_social" class="form-label">Razon Social</label>
                    <input type="text" class="form-control" name="razon_social" id="razon_social" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="numero_identificacion" class="form-label">Número de Identificación</label>
                    <input type="number" class="form-control" name="numero_identificacion" id="numero_identificacion">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection