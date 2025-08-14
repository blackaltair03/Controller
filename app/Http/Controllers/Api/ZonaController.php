<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ZonaController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Zona::all(),
            'message' => 'Zonas recuperadas exitosamente.'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:zonas',
            'nombre' => 'required|string|max:50',
            'tipo' => ['required', Rule::in(['general', 'hotel', 'acampar'])],
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $zona = Zona::create($request->all());

        return response()->json(['success' => true, 'data' => $zona, 'message' => 'Zona creada exitosamente.'], 201);
    }

    public function show(Zona $zona)
    {
        // Carga las relaciones específicas según el tipo de zona
        $zona->loadMissing(['zonaGeneral', 'zonaHotel', 'zonaAcampar']);
        return response()->json(['success' => true, 'data' => $zona, 'message' => 'Zona encontrada.']);
    }

    public function update(Request $request, Zona $zona)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'sometimes|required|string|unique:zonas,codigo,' . $zona->id,
            'nombre' => 'sometimes|required|string|max:50',
            'tipo' => ['sometimes', 'required', Rule::in(['general', 'hotel', 'acampar'])],
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $zona->update($request->all());

        return response()->json(['success' => true, 'data' => $zona, 'message' => 'Zona actualizada exitosamente.']);
    }

    public function destroy(Zona $zona)
    {
        $zona->delete();
        return response()->json(['success' => true, 'message' => 'Zona eliminada exitosamente.'], 200);
    }
}