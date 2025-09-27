<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class ServicioController extends Controller
{
    /**
     * Transformar servicio para la respuesta.
     */
    private function transform(Servicio $servicio)
    {
        return [
            'codigo' => $servicio->codigo,
            'nombre' => $servicio->nombre,
            'descripcion' => $servicio->descripcion,
        ];
    }

    /**
     * Listar servicios.
     */
    public function index()
    {
        try {
            $servicios = Servicio::paginate(10);
            $data = $servicios->getCollection()->map(fn($s) => $this->transform($s));
            $servicios->setCollection($data);

            return response()->json([
                'success' => true,
                'message' => 'Lista de servicios obtenida correctamente',
                'data' => $servicios
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener servicios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear servicio.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'required|string|max:20|unique:servicios,codigo',
                'nombre' => 'required|string|max:50',
                'descripcion' => 'nullable|string|max:255',
            ]);

            $servicio = Servicio::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Servicio creado correctamente',
                'data' => $this->transform($servicio)
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
                'message' => 'Error al crear servicio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar servicio.
     */
    public function show(Servicio $servicio)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Servicio obtenido correctamente',
                'data' => $this->transform($servicio)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener servicio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar servicio.
     */
    public function update(Request $request, Servicio $servicio)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'sometimes|string|max:20|unique:servicios,codigo,' . $servicio->id,
                'nombre' => 'sometimes|string|max:50',
                'descripcion' => 'nullable|string|max:255',
            ]);

            $servicio->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Servicio actualizado correctamente',
                'data' => $this->transform($servicio)
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
                'message' => 'Error al actualizar servicio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar servicio.
     */
    public function destroy(Servicio $servicio)
    {
        try {
            $servicio->delete();

            return response()->json([
                'success' => true,
                'message' => 'Servicio eliminado correctamente',
                'data' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar servicio',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
