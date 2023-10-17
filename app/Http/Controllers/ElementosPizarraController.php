<?php

namespace App\Http\Controllers;

use App\Models\elementoPizarra;
use App\Models\pizarra;
use Illuminate\Http\Request;

class ElementosPizarraController extends Controller
{
Public function crearElemento(Request $request) {

    $request->validate([
        'pizarra_id' => 'required',
        'tipo' => 'required',
        'nombre' => 'required',
        'posicion_x' => 'required',
        'posicion_y' => 'required',
        'cid' => 'required',
        'contenido' => 'required',
    ]);
    $elemento = new ElementoPizarra;

    $elemento->pizarra_id = $request->pizarra_id; // Asegúrate de que pizarra_id se pase en la solicitud.
    $elemento->tipo = $request->tipo;
    $elemento->nombre = $request->nombre;
    $elemento->posicion_x = $request->posicion_x;
    $elemento->posicion_y = $request->posicion_y;
    $elemento->cid = $request->cid;
    $elemento->contenido = $request->contenido;

    $elemento->save();

    return response()->json(['message' => 'Elemento creado con éxito', 'elemento' => $elemento]);

    }
    public function eliminarElementosPorTipo($tipoAEliminar) {
        // Realiza la eliminación de elementos en la base de datos.
        // Supongamos que tienes un campo 'tipo' en tu modelo para identificar el tipo del elemento.
        elementoPizarra::where('tipo', $tipoAEliminar)->delete();

        return response()->json(['success' => true, 'message' => 'Elementos eliminados con éxito']);
    }
    public function actualizarPosicion(Request $request, $pizarraId) {
        // Valida y sanitiza los datos del formulario, si es necesario
        $request->validate([
            'nuevaPosicionX' => 'required',
            'nuevaPosicionY' => 'required',
            'elementoCid' => 'required'
        ]);
        // Encuentra el elemento en la base de datos
        $elemento = ElementoPizarra::where('pizarra_id', $pizarraId)->where('cid', $request->elementoCid)->first();

        if ($elemento) {
            // Actualiza la posición del elemento
            $elemento->posicion_x = $request->nuevaPosicionX;
            $elemento->posicion_y = $request->nuevaPosicionY;
            $elemento->save();

            // Puedes agregar un mensaje de éxito o redirección aquí si es necesario
            return response()->json(['message' => 'La posición se ha actualizado con éxito.']);
        } else {
            // Puedes manejar el caso en el que el elemento no se encuentre
            return response()->json(['error' => 'Elemento no encontrado en la pizarra especificada.']);
        }
    }

}
