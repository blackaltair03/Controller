<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brazalete;
use Illuminate\Validation\ValidationException;
use Exception;

class BrazaleteController extends Controller
{
    /**
     * Transformar brazalete para la respuesta.
     */
    private function transform(Brazalete $brazalete)
    {
        return [
            'qr_code' => $brazalete->qr_code,
            'fecha_in' => $brazalete->fecha_in,
            'fecha_out' => $brazalete->fecha_out,
            'estatus' => $brazalete->estatus->nombre ?? null,
            'contador_reingresos' => $brazalete->contador_reingresos,
        ];
    }

    /**
     * Listar brazaletes.
     */
    public function index()
    {
        try {
            $brazaletes = Brazalete::with('estatus')->paginate(10);
            $data = $brazaletes->getCollection()->map(fn($b) => $this->transform($b));
            $brazaletes->setCollection($data);

            return response()->json([
                'success' => true,
                'message' => 'Lista de brazaletes obtenida correctamente',
                'data' => $brazaletes
            ]);
        } catch (Exception $e) {
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
                'data' => $this->transform($brazalete)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
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
                'data' => $this->transform($brazalete->load('estatus'))
            ]);
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        try {
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
                'data' => $this->transform($brazalete)
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
                'message' => 'Error al validar brazalete',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
