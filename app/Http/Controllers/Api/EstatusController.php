<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estatus;
use Illuminate\Http\Request;


class EstatusController extends Controller
{
    public function indez()
    {
        return response()->json(Estatus::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:20|unique:estatus',
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $estatus = Estatus::create($validated);
        return response()->json($estatus, 201);
    }

    public function show(Estatus $estatus)
    {
        return response()->json($estatus);
    }

    public function update (Request $request, Estatus $estatus)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:20|unique|estatuses,codigo,' . $estatus->id,
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $estatus->update($validated);
        return response()->json($estatus);
    }

    public function destroy(Estatus $estatus)
    {
        $estatus->delete();
        return response()->json([
            'message' => 'Estatus eliminado'
        ]);
    }


}

