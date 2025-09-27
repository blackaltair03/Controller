<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class EventoController extends Controller
{
    /**
     * Transformar evento para la respuesta.
     */
    private function transform(Evento $evento)
    {
        return [
            'codigo' => $evento->codigo,
            'duracion' => $evento->duracion,
            'descripcion' => $evento->descripcion,
        ];
    }

    /**
     * Listar eventos.
     */
    public function index()
    {
        try {
            $eventos = Evento::paginate(10);
            $data = $eventos->getCollection()->map(fn($e) => $this->transform($e));
            $eventos->setCollection($data);

            return response()->json([
                'success' => true,
                'message' => 'Lista de eventos obtenida correctamente',
                'data' => $eventos
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener eventos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear evento.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'required|string|max:20|unique:eventos,codigo',
                'duracion' => 'required|integer|min:1',
                'descripcion' => 'required|string|max:255',
            ]);

            $evento = Evento::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Evento creado correctamente',
                'data' => $this->transform($evento)
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
                'message' => 'Error al crear evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar evento.
     */
    public function show(Evento $evento)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Evento obtenido correctamente',
                'data' => $this->transform($evento)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar evento.
     */
    public function update(Request $request, Evento $evento)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'sometimes|string|max:20|unique:eventos,codigo,' . $evento->id,
                'duracion' => 'sometimes|integer|min:1',
                'descripcion' => 'nullable|string|max:255',
            ]);

            $evento->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Evento actualizado correctamente',
                'data' => $this->transform($evento)
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
                'message' => 'Error al actualizar evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar evento.
     */
    public function destroy(Evento $evento)
    {
        try {
            $evento->delete();

            return response()->json([
                'success' => true,
                'message' => 'Evento eliminado correctamente',
                'data' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
