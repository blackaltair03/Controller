<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Listar eventos.
     */
    public function index()
    {
        try {
            $eventos = Evento::paginate(10);
            return response()->json([
                'success' => true,
                'message' => 'Lista de eventos obtenida correctamente',
                'data' => $eventos
            ]);
        } catch (\Exception $e) {
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
                'data' => $evento
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
                'data' => $evento
            ]);
        } catch (\Exception $e) {
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
                'data' => $evento
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}