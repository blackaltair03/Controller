<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;


class ServicioController extends Controller
{
    public function index()
    {
        return response()->json(Servicio::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:20|unique:servicios',
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $servicio = Servicio::create($validated);
        return response()->json($servicio, 201);
    }

    public function show(Servicio $servicio)
    {
        return response()->json($servicio);
    }

    public function update(Request $request, Servicio $servicio)
    {
        $validated = $request->validate([
            'codigo' => 'sometimes|string|max:20|unique:servicios,codigo,' . $servicio->id,
            'nombre' => 'sometimes|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $servicio->update($validated);
        return response()->json($servicio);
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return response()->json([
            'message' => 'Servicio Eliminado'
        ]);
    }
}
