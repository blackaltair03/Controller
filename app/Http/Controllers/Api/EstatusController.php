<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstatusController extends Controller
{
    /**
     * Muestra una lista de los recursos.
     */
    public function index()
    {
        return response()->json([
            'success' => true, 
            'data' => Estatus::all(), 
            'message' => 'Estatus recuperados exitosamente.'
        ]);
    }

    /**
     * Almacena un recurso recién creado.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:estatus',
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $estatus = Estatus::create($request->all());

        return response()->json(['success' => true, 'data' => $estatus, 'message' => 'Estatus creado exitosamente.'], 201);
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Estatus $estatu)
    {
        return response()->json(['success' => true, 'data' => $estatu, 'message' => 'Estatus encontrado.']);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Estatus $estatu)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'sometimes|required|string|unique:estatus,codigo,' . $estatu->id,
            'nombre' => 'sometimes|required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $estatu->update($request->all());

        return response()->json(['success' => true, 'data' => $estatu, 'message' => 'Estatus actualizado exitosamente.']);
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Estatus $estatu)
    {
        $estatu->delete();
        return response()->json(['success' => true, 'message' => 'Estatus eliminado exitosamente.'], 200);
    }
}