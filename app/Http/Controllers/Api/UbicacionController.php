<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    /**
     * Listar ubicaciones.
     */
    public function index()
    {
        try {
            $ubicaciones = Ubicacion::paginate(10);
            return response()->json([
                'success' => true,
                'message' => 'Lista de ubicaciones obtenida correctamente',
                'data' => $ubicaciones
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener ubicaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear ubicación.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'required|string|max:20|unique:ubicaciones,codigo',
                'nombre' => 'required|string|max:50',
                'descripcion' => 'nullable|string|max:255',
            ]);

            $ubicacion = Ubicacion::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ubicación creada correctamente',
                'data' => $ubicacion
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
                'message' => 'Error al crear ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar ubicación.
     */
    public function show(Ubicacion $ubicacion)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Ubicación obtenida correctamente',
                'data' => $ubicacion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar ubicación.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'sometimes|string|max:20|unique:ubicaciones,codigo,' . $ubicacion->id,
                'nombre' => 'sometimes|string|max:50',
                'descripcion' => 'nullable|string|max:255',
            ]);

            $ubicacion->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ubicación actualizada correctamente',
                'data' => $ubicacion
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar ubicación.
     */
    public function destroy(Ubicacion $ubicacion)
    {
        try {
            $ubicacion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ubicación eliminada correctamente',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
