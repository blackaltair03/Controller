<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        return response()->json(Evento::all);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:20|unique:eventos',
            'duracion' => 'required|integer|min:1',
            'descripcion' => 'required|string|max:255',
        ]);

        $evento = Evento::create($validated);
        return response()->json($evento, 201);
    }

    public function show(Evento $evento) 
    {
        return response()->json($evento);
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validated([
            'codigo' => 'sometimes|string|max:20|unique:eventos.codigo,' . $evento->id,
            'duracion' => 'sometimes|integer|min:1',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $evento->update($validated);
        return response()->json($evento);
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return response()->json([
            'message' => 'Evento eliminad0'
        ]);
    }
}