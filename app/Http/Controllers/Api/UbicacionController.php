<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UbicacionController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Ubicacion::all(),
            'message' => 'Ubicaciones recuperadas exitosamente.'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:ubicacions',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $ubicacion = Ubicacion::create($request->all());

        return response()->json(['success' => true, 'data' => $ubicacion, 'message' => 'Ubicación creada exitosamente.'], 201);
    }

    public function show(Ubicacion $ubicacion)
    {
        return response()->json(['success' => true, 'data' => $ubicacion, 'message' => 'Ubicación encontrada.']);
    }

    public function update(Request $request, Ubicacion $ubicacion)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'sometimes|required|string|unique:ubicacions,codigo,' . $ubicacion->id,
            'nombre' => 'sometimes|required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $ubicacion->update($request->all());

        return response()->json(['success' => true, 'data' => $ubicacion, 'message' => 'Ubicación actualizada exitosamente.']);
    }

    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return response()->json(['success' => true, 'message' => 'Ubicación eliminada exitosamente.'], 200);
    }
}