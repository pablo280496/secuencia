@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-lg-right">
            <div id=""> <!-- Fila pequeña para los componentes (objetos) -->
                <div class="card-body row-cols-2">
                    <div class="col-12 ">
                        <button id="btnAddActor" type="button" class="btn btn-outline-success">Agregar Actor</button>
                        <button id="btnAddEntidad" type="button" class="btn btn-outline-danger">Agregar Entidad</button>
                        <button id="btnAddControl" type="button" class="btn btn-outline-warning">Agregar Control</button>

                        <button id="btnDelActor" type="button" class="btn btn-outline-success">Eliminar Actor</button>
                        <button id="btnDelEntidad" type="button" class="btn btn-outline-danger">Eliminar Entidad</button>
                        <button id="btnDelControl" type="button" class="btn btn-outline-warning">Eliminar Control</button>
                        <button id="btnGuardarMensaje"type="button" class="btn btn-primary">Agregar mensaje</button>

                    @if(auth()->id() === $pizarra->creador_id)
                            @php
                                $invitationCode = $pizarra->invitation_code; // no hace nada ahora borrarlo despues
                            @endphp
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                            Generar Codigo de invitacion
                        </button>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel2">codigo de invitación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{$pizarra->invitation_code}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr class="mt-3">
            <div id="app">
                <home>
                    <div id="canvas-section"> <!-- Sección para la pizarra -->
                        <div class="col-md-12">

                            <input type="hidden" id="pizarraId" value="{{ request('id') }}">
                            <input type="text">
                        </div>
                    </div>
                </home>
        </div>
    </div>

        <script>

            //import * as joint from 'jointjs';
            // Define la variable 'elementos' en JavaScript y asigna los datos que obtuviste desde el controlador de Laravel.
            const elementos = @json($elementos);
            console.log(elementos);
            //console.log(elementos.length);
            localStorage.setItem('elementos', JSON.stringify(elementos))
            // Ahora puedes usar 'elementos' en JavaScript.
            console.log(elementos);

        </script>
@endsection

