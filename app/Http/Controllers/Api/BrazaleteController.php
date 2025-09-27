<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brazalete;

class BrazaleteController extends Controller
{
    /**
     * Listar brazaletes.
     */
    public function index()
    {
        try {
            $brazaletes = Brazalete::with('estatus')->paginate(10);
            return response()->json([
                'success' => true,
                'message' => 'Lista de brazaletes obtenida correctamente',
                'data' => $brazaletes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener brazaletes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear brazalete.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'qr_code' => 'required|string|unique:brazaletes,qr_code',
                'fecha_in' => 'required|date',
                'fecha_out' => 'required|date|after:fecha_in',
                'estatus_id' => 'required|exists:estatus,id',
                'contador_reingresos' => 'integer|min:0',
            ]);

            $brazalete = Brazalete::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Brazalete creado correctamente',
                'data' => $brazalete
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear brazalete',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar brazalete.
     */
    public function show(Brazalete $brazalete)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Brazalete obtenido correctamente',
                'data' => $brazalete->load('estatus')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener brazalete',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar brazalete.
     */
    public function destroy(Brazalete $brazalete)
    {
        try {
            $brazalete->delete();
            return response()->json([
                'success' => true,
                'message' => 'Brazalete eliminado correctamente',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar brazalete',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validar brazalete por QR.
     */
    public function validar(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);

        $brazalete = Brazalete::where('qr_code', $request->qr_code)
            ->with('estatus')
            ->first();

        if (!$brazalete) {
            return response()->json([
                'success' => false,
                'message' => 'Brazalete no encontrado',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Brazalete válido',
            'data' => $brazalete
        ]);
    }
}