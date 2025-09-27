<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estatus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class EstatusController extends Controller
{
    /**
     * Transformar estatus para la respuesta.
     */
    private function transform(Estatus $estatus)
    {
        return [
            'codigo' => $estatus->codigo,
            'nombre' => $estatus->nombre,
            'descripcion' => $estatus->descripcion,
        ];
    }

    /**
     * Listar estatus.
     */
    public function index()
    {
        try {
            $estatus = Estatus::paginate(10);
            $data = $estatus->getCollection()->map(fn($e) => $this->transform($e));
            $estatus->setCollection($data);

            return response()->json([
                'success' => true,
                'message' => 'Lista de estatus obtenida correctamente',
                'data' => $estatus
            ]);
        } catch (Exception $e) {
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
                'data' => $this->transform($estatus)
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
                'data' => $this->transform($estatus)
            ]);
        } catch (Exception $e) {
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
                'data' => $this->transform($estatus)
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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar estatus',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
