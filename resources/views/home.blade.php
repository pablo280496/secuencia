@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <h4 class="text-center">Tus Pizarras</h4>
        <div class="col-md-10">
            <table class="table table-hover">
                <thead>
                    <tr >
                        <th scope="col">id</th>
                        <th scope="col">nombre</th>
                        <th scope="col">descripcion</th>
                        <th scope="col">rol</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                        <tbody>
                            @foreach ($pizarras as $pizarra)
                                <tr class="pizarra-row">
                                    <th scope="row">{{ $pizarra->id }}</th>
                                    <td> {{ $pizarra->nombre }}</td>
                                    <td>{{ $pizarra->descripcion }}</td>
                                    <td>
                                        {{ $pizarra->pivot->rol }}
                                    </td>
                                    <td>
                                        <a href="{{ route('pizarra.dashboard', ['id' => $pizarra->id]) }}">
                                            [Ingresar]
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
