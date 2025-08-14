<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Servicio::all(),
            'message' => 'Servicios recuperados exitosamente.'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:servicios',
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $servicio = Servicio::create($request->all());

        return response()->json(['success' => true, 'data' => $servicio, 'message' => 'Servicio creado exitosamente.'], 201);
    }

    public function show(Servicio $servicio)
    {
        return response()->json(['success' => true, 'data' => $servicio, 'message' => 'Servicio encontrado.']);
    }

    public function update(Request $request, Servicio $servicio)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'sometimes|required|string|unique:servicios,codigo,' . $servicio->id,
            'nombre' => 'sometimes|required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $servicio->update($request->all());

        return response()->json(['success' => true, 'data' => $servicio, 'message' => 'Servicio actualizado exitosamente.']);
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return response()->json(['success' => true, 'message' => 'Servicio eliminado exitosamente.'], 200);
    }
}