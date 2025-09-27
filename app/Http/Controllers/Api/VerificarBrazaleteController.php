<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brazalete;
use App\Models\Evento;
use App\Models\Servicio;
use App\Models\Ubicacion;
use App\Http\Resources\BrazaleteResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;

class VerificarBrazaleteController extends Controller
{
    /**
     * Verifica la validez de un brazalete a partir de una cadena.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = $request->validate([
                'cadena_brazalete' => 'required|string',
            ]);

            $partes = explode('/', $validated['cadena_brazalete']);

            if (count($partes) !== 6) {
                return response()->json([
                    'success' => false,
                    'message' => 'Formato de cadena inválido. Se esperaban 6 partes separadas por "/".',
                    'data' => null
                ], 400);
            }

            [$evento_codigo, $ubicacion_codigo, $servicio_codigo, $fecha_str, $hora_str, $qr_code] = $partes;

            $evento = Evento::where('codigo', $evento_codigo)->first();
            $ubicacion = Ubicacion::where('codigo', $ubicacion_codigo)->first();
            $servicio = Servicio::where('codigo', $servicio_codigo)->first();
            $brazalete = Brazalete::with('estatus')->where('qr_code', $qr_code)->first();

            $missing = [];
            if (!$evento) $missing[] = "evento '{$evento_codigo}'";
            if (!$ubicacion) $missing[] = "ubicación '{$ubicacion_codigo}'";
            if (!$servicio) $missing[] = "servicio '{$servicio_codigo}'";
            if (!$brazalete) $missing[] = "brazalete '{$qr_code}'";

            if (!empty($missing)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos no encontrados: ' . implode(', ', $missing) . '.',
                    'data' => null
                ], 404);
            }

            if ($brazalete->estatus->codigo !== 'ACTV') {
                return response()->json([
                    'success' => false,
                    'message' => 'Acceso denegado. El brazalete no se encuentra activo.',
                    'data' => [
                        'estatus_actual' => $brazalete->estatus->nombre
                    ]
                ], 403);
            }

            if (Carbon::now()->gt($brazalete->fecha_out)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acceso denegado. El brazalete ha expirado.',
                    'data' => [
                        'fecha_expiracion' => $brazalete->fecha_out->format('d-m-Y H:i:s')
                    ]
                ], 403);
            }

            try {
                Carbon::createFromFormat('dmY H:i', $fecha_str . ' ' . $hora_str);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'El formato de fecha u hora en la cadena es inválido.',
                    'data' => null
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Brazalete válido y verificado. ¡Acceso permitido!',
                'data' => new BrazaleteResource($brazalete)
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar brazalete',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
