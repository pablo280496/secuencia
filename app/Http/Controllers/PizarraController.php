<?php

namespace App\Http\Controllers;

use App\Events\ActualizacionPizarraEvent;
use App\Events\CrearPizarraEvent;
use App\Events\MoverElementoEvent;
use App\Models\elementoPizarra;
use App\Models\pizarra;
use App\Models\usuario_pizarra;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PizarraController extends Controller
{
// Método para mostrar el formulario de creación de pizarra
    public function createForm()
    {
        return view('pizarra.create'); // Asegúrate de crear esta vista en resources/views/pizarra/create.blade.php
    }

    // Método para procesar la creación de una pizarra

    public function create(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        // Genera un UUID como código de invitación
        $invitationCode = Str::uuid();
        // Crea una nueva pizarra en la base de datos
        $pizarra = Pizarra::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'creador_id' => auth()->user()->id, // Esto asume que estás autenticando usuarios en tu aplicación
            'invitation_code' => $invitationCode, // Almacena el código de invitación
        ]);
        $usuarioPizarra = new usuario_pizarra([
            'id_user' => auth()->user()->id,
            'id_pizarra' => $pizarra->id,
            'rol' => 'Administrador',// Aquí estableces el rol, por ejemplo, administrador
        ]);
        $usuarioPizarra->save();

        $pizarraId = $pizarra->id;
        $data = [
            'idSala' => $pizarraId,
        ];
        event(new CrearPizarraEvent($data));

        // Redirige a una página de éxito o a donde desees
        return redirect()->route('pizarra.dashboard', ['id' => $pizarra->id])->with('success', 'Pizarra creada exitosamente.');
    }

    public function index()
    {
        $pizarrasRegisterUrl = route('pizarra.register');
        return view('/pizarras/create', compact('pizarrasRegisterUrl'));
    }

    public function mostrarPizarra($id)
    {
        $pizarra_user = usuario_pizarra::all();
        $pizarra = pizarra::all(); // Aquí obtén tus pizarras desde la base de datos
        $user = auth()->user();
        return view('pizarra.dashboard', ['pizarras' => $pizarra, 'usuario' => $user]);

    }

    public function esPizarra($id)
    {   $elementos = elementoPizarra::where('pizarra_id', $id)->get();
        $pizarra = pizarra::find($id);
        return view('pizarra.dashboard', ['pizarra' => $pizarra, 'elementos' =>$elementos]);
    }

    public function unirsePizarra(Request $request)
    {
        // Obtén el código de invitación desde el formulario
        $codigoInvitacion = $request->input('codigo_invitacion');

        // Verifica si el código de invitación es válido y obtén la pizarra correspondiente
        $pizarra = Pizarra::where('invitation_code', $codigoInvitacion)->first();

        if (!$pizarra) {
            // Maneja el caso en el que el código de invitación no sea válido
            return redirect()->route('home')->with('error', 'Código de invitación no válido.');
        }
        // Agrega al usuario a la tabla usuario_pizarra con el rol apropiado
        $usuarioPizarra = new usuario_pizarra([
            'id_user' => auth()->user()->id,
            'id_pizarra' => $pizarra->id,
            'rol' => 'Participante',
        ]);
        $usuarioPizarra->save();
        $pizarraId = $pizarra->id;
        $data = [
            'idSala' => $pizarraId,
        ];
        event(new ActualizacionPizarraEvent($data));
        // Redirige al usuario a la página de la pizarra

        return redirect()->route('pizarra.dashboard', ['id' => $pizarra->id]);
    }

    public function mostrarLienzo($pizarraId) {
        $elementos = elementoPizarra::where('pizarra_id', $pizarraId)->get();
        return view('pizarra.dashboard', ['elementos' => $elementos]);
    }

}

