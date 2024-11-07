@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('INICIO') }}</div>

                <div class="card-body">
                    @if (Auth::check() && (Auth::User()->role < 3))
                        <div class="row">
                            <div class="col">
                            <a href="{{route("showCreateCompanies")}}"><button type="button" class="btn btn-dark">Crear Empresas</button></a>
                            </div>
                        </div>
                    @endif
                    <div class="row justify-content-center mb-3 mt-2">
                        <div class="col">
                            <a href=""><button type="button" class="btn btn-dark">Registrar usuario</button></a>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-3 mt-2">
                        <div class="col">
                            <a href="{{route("showUploadPlantilla")}}"><button type="button" class="btn btn-dark">Subir plantilla excel</button></a>
                        </div>
                        <div class="col">
                            <a href=""><button type="button" class="btn btn-dark">diligenciar formulario sostenibilidad</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection