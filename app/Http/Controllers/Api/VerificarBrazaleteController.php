<?php

// app/Http/Controllers/Api/VerificarBrazaleteController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brazalete;
use App\Models\Evento;
use App\Models\Servicio;
use App\Models\Ubicacion;
use App\Http\Resources\BrazaleteResource;
use Carbon\Carbon; // Importante para el manejo de fechas

class VerificarBrazaleteController extends Controller
{
    /**
     * Verifica la validez de un brazalete a partir de una cadena.
     * Este método actúa como un controlador de acción única (invokable).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        // 1. Validación inicial de la petición
        $validated = $request->validate([
            'cadena_brazalete' => 'required|string',
        ]);

        $partes = explode('/', $validated['cadena_brazalete']);

        // 2. Validar que la cadena tenga el formato correcto
        if (count($partes) !== 6) {
            return response()->json(['message' => 'Formato de cadena inválido. Se esperaban 6 partes separadas por "/".'], 400);
        }

        [$evento_codigo, $ubicacion_codigo, $servicio_codigo, $fecha_str, $hora_str, $qr_code] = $partes;

        // 3. Búsqueda de registros en la base de datos
        $evento = Evento::where('codigo', $evento_codigo)->first();
        $ubicacion = Ubicacion::where('codigo', $ubicacion_codigo)->first();
        $servicio = Servicio::where('codigo', $servicio_codigo)->first();
        // Cargamos la relación 'estatus' para tenerla disponible y mejorar rendimiento
        $brazalete = Brazalete::with('estatus')->where('qr_code', $qr_code)->first();

        // 4. Validar que todos los códigos existan en la base de datos
        if (!$evento || !$ubicacion || !$servicio || !$brazalete) {
            $missing = [];
            if (!$evento) $missing[] = "evento '{$evento_codigo}'";
            if (!$ubicacion) $missing[] = "ubicación '{$ubicacion_codigo}'";
            if (!$servicio) $missing[] = "servicio '{$servicio_codigo}'";
            if (!$brazalete) $missing[] = "brazalete '{$qr_code}'";
            
            return response()->json(['message' => 'Datos no encontrados: ' . implode(', ', $missing) . '.'], 404);
        }

        // --- LÓGICA DE NEGOCIO ADICIONAL ---

        // 5. Validar el estatus del brazalete
        // Asumimos que 'ACTV' es el código para un brazalete activo
        if ($brazalete->estatus->codigo !== 'ACTV') {
            return response()->json([
                'message' => 'Acceso denegado. El brazalete no se encuentra activo.',
                'estatus_actual' => $brazalete->estatus->nombre
            ], 403); // 403 Forbidden: El servidor entendió la petición, pero se niega a autorizarla.
        }

        // 6. Validar la fecha de expiración del brazalete
        // Comparamos la fecha y hora actual con la fecha de salida del brazalete
        if (Carbon::now()->gt($brazalete->fecha_out)) {
            // Si la fecha actual es mayor (greater than), el brazalete ha expirado
            return response()->json([
                'message' => 'Acceso denegado. El brazalete ha expirado.',
                'fecha_expiracion' => $brazalete->fecha_out->format('d-m-Y H:i:s')
            ], 403);
        }
        
        // 7. Opcional: Validar la fecha y hora de la cadena
        // Esto puede ser útil si la cadena tiene una validez propia (ej. solo válida por 5 min)
        try {
            $fechaCadena = Carbon::createFromFormat('dmY H:i', $fecha_str . ' ' . $hora_str);
            // Ejemplo: if (Carbon::now()->diffInMinutes($fechaCadena) > 5) { ... }
        } catch (\Exception $e) {
            return response()->json(['message' => 'El formato de fecha u hora en la cadena es inválido.'], 400);
        }


        // 8. Respuesta de éxito
        // Si todas las validaciones pasan, el acceso es permitido.
        return response()->json([
            'message' => 'Brazalete válido y verificado. ¡Acceso permitido!',
            'data' => new BrazaleteResource($brazalete) // Usamos el Resource para una respuesta consistente
        ]);
    }
}
