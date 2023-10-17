@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{route('pizarra.create.formulario')}}">
            @csrf
            <!-- Agrega aquí los campos del formulario -->
            <div class="form-group">
                <label for="nombre">Nombre de la pizarra:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nombre">descripcion:</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
            </div>
            <!-- Otros campos del formulario -->
            <div>
                <button type="submit" class="btn btn-primary">Crear Pizarra</button>
            </div>

        </form>
    </div>
@endsection
