<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brazalete;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BrazaleteController extends Controller
{
    public function index()
    {
        try {
            $brazaletes = Brazalete::with('estatus')->get();
            return response()->json([
                'data' => $brazaletes,
                'success' => true,
                'message' => 'Brazaletes recuperados exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cadena' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos', 'errors' => $validator->errors()], 422);
        }

        $partes = explode('/', $request->input('cadena'));
        if (count($partes) !== 6) {
            return response()->json(['success' => false, 'message' => 'La estructura de la cadena es incorrecta. Formato esperado: codigo_evento/codigo_ubicacion/XY/fecha/hora/qr_code'], 400);
        }

        [$codigo_evento, $codigo_ubicacion, $xy, $fecha, $hora, $qr_code] = $partes;

        if (Brazalete::where('qr_code', $qr_code)->exists()) {
            return response()->json(['success' => false, 'message' => 'El código QR ya existe.'], 409);
        }
        
        $evento = Evento::where('codigo', $codigo_evento)->first();
        if (!$evento) {
            return response()->json(['success' => false, 'message' => 'El código de evento no es válido.'], 404);
        }
        
        try {
            $fecha_in = Carbon::createFromFormat('dmY H:i', $fecha . ' ' . substr_replace($hora, ':', 2, 0));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'El formato de fecha u hora es incorrecto. Use ddmmaaaa y hhmm.'], 400);
        }

        $brazalete = Brazalete::create([
            'qr_code' => $qr_code,
            'fecha_in' => $fecha_in,
            'estatus_id' => 2, // Activo por defecto
        ]);

        return response()->json([
            'data' => $brazalete,
            'success' => true,
            'message' => 'Brazalete creado y activado correctamente.',
        ], 201);
    }

    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qr_code' => 'required|string|exists:brazaletes,qr_code',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'El código QR no existe o es inválido.'], 404);
        }

        $brazalete = Brazalete::with('estatus')->where('qr_code', $request->input('qr_code'))->first();
        
        // Simulación: Buscamos el evento estándar de 4 horas para la validación.
        $evento = Evento::where('codigo', '1234')->first();
        $fecha_vencimiento = $brazalete->fecha_in->addMinutes($evento->duracion);

        if (Carbon::now()->gt($fecha_vencimiento)) {
            if ($brazalete->estatus_id != 3) { // Si no está ya rechazado
                $brazalete->estatus_id = 3; // 'RCHZ'
                $brazalete->fecha_out = Carbon::now();
                $brazalete->save();
            }
            return response()->json([
                'success' => false,
                'message' => 'El tiempo de vigencia del brazalete ha expirado.',
            ], 403);
        }
        
        if ($brazalete->estatus_id == 2) { // 'ACTV'
            return response()->json([
                'sum_validar' => 1,
                'validar' => true,
                'success' => true,
                'message' => 'El brazalete es válido y está activo.',
                'data' => $brazalete
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'El brazalete no está activo. Estatus actual: ' . $brazalete->estatus->nombre,
                'data' => $brazalete
            ], 403);
        }
    }
}