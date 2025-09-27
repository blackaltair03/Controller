<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Listar zonas.
     */
    public function index()
    {
        try {
            $zonas = Zona::with('ubicacion')->paginate(10);
            return response()->json([
                'success' => true,
                'message' => 'Lista de zonas obtenida correctamente',
                'data' => $zonas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener zonas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear zona.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'ubicacion_id' => 'required|exists:ubicaciones,id',
                'capacidad' => 'required|integer|min:1',
            ]);

            $zona = Zona::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Zona creada correctamente',
                'data' => $zona
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
                'message' => 'Error al crear zona',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar zona.
     */
    public function show(Zona $zona)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Zona obtenida correctamente',
                'data' => $zona->load('ubicacion')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener zona',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar zona.
     */
    public function update(Request $request, Zona $zona)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'descripcion' => 'nullable|string',
                'ubicacion_id' => 'sometimes|exists:ubicaciones,id',
                'capacidad' => 'sometimes|integer|min:1',
            ]);

            $zona->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Zona actualizada correctamente',
                'data' => $zona
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
                'message' => 'Error al actualizar zona',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar zona.
     */
    public function destroy(Zona $zona)
    {
        try {
            $zona->delete();
            return response()->json([
                'success' => true,
                'message' => 'Zona eliminada correctamente',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar zona',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}