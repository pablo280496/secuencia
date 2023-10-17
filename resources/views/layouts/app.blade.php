<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The JointJS Sequence Diagram demo serves as a template to help bring your idea to life in no time.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{  'Diagrama' }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', ])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>


    <!-- JavaScript relacionado con la pizarra -->
    <!-- Importa la biblioteca de Pusher -->
    <script>
        /*Pusher.logToConsole = true;
        const pusher = new Pusher('767eb9c2b0be4f04a695', {
        cluster: 'us2',
        encrypted: true
        });
        <!-- Define un canal de Pusher al que te suscribirás -->
        const channel = pusher.subscribe('diagr_sec');
        channel.bind('App\\Events\\CrearPizarraEvent', function(data) {
            // Acciones a realizar cuando se crea una pizarra
            console.log('Pizarra creada con ID:', data);
            // Redirige al usuario al dashboard de la sala si es necesario
        });
        channel.bind('App\\Events\\MoverElementoEvent', function(data) {
            // Acciones a realizar cuando un elemento se mueve
            console.log('Elemento movido:', data);
            // Puedes actualizar la interfaz del usuario con la nueva posición del elemento
            // O realizar otras acciones necesarias.
        });
        channel.bind('App\\Events\\ActualizarPizarraEvent', function(data) {

            console.log('pizarra actualizada', data);
        });
        channel.bind('App\\Events\\AgregarElementoEvent', function(data) {
            console.log('Elemento agregado', data);
        });
        // Escuchar el evento de elementos eliminados
        channel.bind('App\\Events\\ElementosEliminados', function(data) {
            console.log('Elementos eliminados', data);
        });*/
    </script>
    <script>


        Echo.logLevel = 'debug'; // Habilita la salida de registros en la consola para depuración.

        // Configura Laravel Echo para usar WebSockets en lugar de Pusher.
        const echo = new Echo({
            broadcaster: 'pusher', // Mantén 'pusher' como broadcaster, ya que Laravel Echo se utiliza de esta manera.
            key: '767eb9c2b0be4f04a695', // Esto es necesario, pero no se utiliza con WebSockets.
            wsHost: window.location.hostname,
            wsPort: 6001, // Asegúrate de que coincida con el puerto de tu servidor WebSocket.
            disableStats: true, // Deshabilita las estadísticas ya que WebSockets no las utiliza.
        });

        // Define los eventos y acciones a realizar cuando se reciben.
        echo.private('diagr_sec')
            .listen('.CrearPizarraEvent', (data) => {
                // Acciones a realizar cuando se crea una pizarra
                console.log('Pizarra creada con ID:', data);
                // Redirige al usuario al dashboard de la sala si es necesario
            })
            .listen('.MoverElementoEvent', (data) => {
                // Acciones a realizar cuando un elemento se mueve
                console.log('Elemento movido:', data);
                // Puedes actualizar la interfaz del usuario con la nueva posición del elemento
                // O realizar otras acciones necesarias.
            })
            .listen('.ActualizarPizarraEvent', (data) => {
                console.log('Pizarra actualizada', data);
            })
            .listen('.AgregarElementoEvent', (data) => {
                console.log('Elemento agregado', data);
            })
            .listen('.ElementosEliminados', (data) => {
                console.log('Elementos eliminados', data);

            });
        socket.on('AgregarElementoPizarra', function(eventData) {
            // Crea un nuevo elemento en el gráfico basado en los datos recibidos
            if (eventData.elementType === 'Actor') {
                const actor = new joint.shapes.standard.Rectangle();
                actor.position(eventData.position);
                actor.resize(100, 40);
                actor.attr({
                    body: {
                        fill: 'lightblue',
                        rx: 10,
                        ry: 10,
                        stroke: 'black'
                    },
                    label: {
                        text: eventData.elementName,
                        fill: 'black'
                    }
                });

                const vidaLinea = new joint.shapes.standard.Path();
                vidaLinea.position(eventData.position.x + 50, 400);
                vidaLinea.attr({
                    path: { d: 'M 0 0 L 0 500' },
                    stroke: 'black'
                });
                const enlace = new joint.dia.Link({
                    source: { id: actor.id },
                    target: { id: vidaLinea.id }
                });

                graph.addCell([actor, vidaLinea, enlace]);
            }
        });
        graph.on('change:position', function(element) {
            const newPosition = element.get('position');
            const elementId = element.id;
            // Aquí, debes emitir un evento WebSocket con la información del movimiento.
            // Puedes usar la biblioteca WebSocket que estás utilizando.
            // Por ejemplo, si estás usando "websocket.io-client":
            socket.emit('mover-elemento', {
                elementId: elementId,
                newPosition: newPosition
            });
        });
        // Escucha el evento de movimiento desde otros clientes
        socket.on('mover-elemento', function(data) {
            // Obtén el elemento en función de su ID
            const element = graph.getCell(data.elementId);
            if (element) {
                // Actualiza la posición del elemento en el lienzo
                element.set('position', data.newPosition);
            }
        });
    </script>

    <!-- Dependencies: -->
    <script>


    </script>

</head>
<body>
    <div id="">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                        <a class="navbar-brand" href="{{ url('/home') }}">
                        {{  'Home' }}
                        </a>
                     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                     </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Inicio de Sesion') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item ms-3">
                                <a class="btn btn-primary float-left" href="{{ route('create.form') }}">{{ __('Crear Sala') }}</a>
                            </li>
                            <li class="nav-fill ms-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                    Unirse a una Sala
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                    <form id="unirsePizarraForm" action="{{ route('unirse.pizarra') }}" method="POST">
                                        @csrf
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel1">Unirse a la Sala</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="message-text" class="col-form-label">Codigo:</label>
                                                        <input type="text" class="form-control" id="codigoInvitacion" name="codigo_invitacion">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <a type="button" class="btn btn-primary" onclick="document.getElementById('unirsePizarraForm').submit();">Aceptar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown ms-3">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script>

</script>

</html>
