<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; //cOPIAR ESTA LINEA DE CODIGO EN LOS DEMAAS CONTROLLERS 
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    // Mostrar todas las ubicaciones
    public function index()
    {
        return response()->json(Ubicacion::all(), 200);
    }

    // Crear una nueva ubicación
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:20|unique:ubicacions,codigo',
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $ubicacion = Ubicacion::create($validated);

        return response()->json($ubicacion, 201);
    }

    // Mostrar una ubicación específica
    public function show(Ubicacion $ubicacion)
    {
        return response()->json($ubicacion, 200);
    }

    // Actualizar una ubicación
    public function update(Request $request, Ubicacion $ubicacion)
    {
        $validated = $request->validate([
            'codigo' => 'sometimes|string|max:20|unique:ubicacions,codigo,' . $ubicacion->id,
            'nombre' => 'sometimes|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $ubicacion->update($validated);

        return response()->json($ubicacion, 200);
    }

    // Eliminar una ubicación
    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();

        return response()->json([
            'message' => 'Ubicación eliminada correctamente'
        ], 200);
    }
}
