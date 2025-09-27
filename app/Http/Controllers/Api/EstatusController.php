<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estatus;
use Illuminate\Http\Request;

class EstatusController extends Controller
{
    /**
     * Listar estatus.
     */
    public function index()
    {
        try {
            $estatus = Estatus::paginate(10);
            return response()->json([
                'success' => true,
                'message' => 'Lista de estatus obtenida correctamente',
                'data' => $estatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estatus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear estatus.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'required|string|max:20|unique:estatus,codigo',
                'nombre' => 'required|string|max:50',
                'descripcion' => 'nullable|string|max:255',
            ]);

            $estatus = Estatus::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Estatus creado correctamente',
                'data' => $estatus
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
                'message' => 'Error al crear estatus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar estatus.
     */
    public function show(Estatus $estatus)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Estatus obtenido correctamente',
                'data' => $estatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estatus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar estatus.
     */
    public function update(Request $request, Estatus $estatus)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'sometimes|string|max:20|unique:estatus,codigo,' . $estatus->id,
                'nombre' => 'sometimes|string|max:50',
                'descripcion' => 'nullable|string|max:255',
            ]);

            $estatus->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Estatus actualizado correctamente',
                'data' => $estatus
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
                'message' => 'Error al actualizar estatus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar estatus.
     */
    public function destroy(Estatus $estatus)
    {
        try {
            $estatus->delete();
            return response()->json([
                'success' => true,
                'message' => 'Estatus eliminado correctamente',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar estatus',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

