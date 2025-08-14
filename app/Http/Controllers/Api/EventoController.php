<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'data' => Evento::all(), 'message' => 'Eventos recuperados.']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:eventos',
            'duracion' => 'required|integer',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $evento = Evento::create($request->all());

        return response()->json(['success' => true, 'data' => $evento, 'message' => 'Evento creado exitosamente.'], 201);
    }

    public function show(Evento $evento)
    {
        return response()->json(['success' => true, 'data' => $evento, 'message' => 'Evento encontrado.']);
    }

    public function update(Request $request, Evento $evento)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'sometimes|required|string|unique:eventos,codigo,' . $evento->id,
            'duracion' => 'sometimes|required|integer',
            'descripcion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $evento->update($request->all());

        return response()->json(['success' => true, 'data' => $evento, 'message' => 'Evento actualizado exitosamente.']);
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return response()->json(['success' => true, 'message' => 'Evento eliminado exitosamente.'], 200);
    }
}