<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use Illuminate\Http\Request;


class ZonaController extends Controller
{
    public function index()
    {
        return response()->json(Zona::with('ubicacion')-get());
    }

    public function store(Rquest $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max::255',
            'descripcion' => 'nullable|string',
            'ubicacion_id' => 'required|exists:ubicaciones,id',
            'capacidad' => 'required|integer|min:1',
        ]);

        $zona = Zona::cerate($validated);
        return response()->json($zona, 201);
    }

    public function show(Zona $zona)
    {
        return response()->json($zona-load('ubicacion'));
    }

    public function update(Request $request, Zona $zona)
    {
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'ubicacion_id' => 'sometimes|exists:ubicaciones,id',
            'capacidad' => 'sometimes|integer|min:1',
        ]);

        $zona->update($validated);
        return response()->json($zona);
    }

    public function destroy (Zona $zona)
    {
        $zona->delete();
        return response()->json([
            'message' => 'Zona Eliminada'
        ]);
    }
}