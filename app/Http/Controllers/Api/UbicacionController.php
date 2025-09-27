<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class UbicacionController extends Controller
{
    /**
     * Transformar ubicación para la respuesta.
     */
    private function transform(Ubicacion $ubicacion)
    {
        return [
            'codigo' => $ubicacion->codigo,
            'nombre' => $ubicacion->nombre,
            'descripcion' => $ubicacion->descripcion,
        ];
    }

    /**
     * Listar ubicaciones.
     */
    public function index()
    {
        try {
            $ubicaciones = Ubicacion::paginate(10);
            $data = $ubicaciones->getCollection()->map(fn($u) => $this->transform($u));
            $ubicaciones->setCollection($data);

            return response()->json([
                'success' => true,
                'message' => 'Lista de ubicaciones obtenida correctamente',
                'data' => $ubicaciones
            ]);
        } catch (Exception $e) {
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
                'data' => $this->transform($ubicacion)
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
                'data' => $this->transform($ubicacion)
            ]);
        } catch (Exception $e) {
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
                'data' => $this->transform($ubicacion)
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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar ubicación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
