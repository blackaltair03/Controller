<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brazalete;

class BrazaleteController extends Controller
{
    public function index()
    {
        return response()->json(Brazalete::all());
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'qr_code' => 'required|string|unique:brazalete',
            'fecha_in' => 'required|date',
            'fecha_out' => 'required|date|after:fecha_in',
            'estatus_id' => 'required|exists:estatus,id',
            'contador_reingresos' => 'integer|min:0|default:0',
        ]);

        $brazalete = Brazalete::create($validated);
        return response()->json($brazalete, 201);
    }

    public function show(Brazalete $brazalete)
    {
        return response()->json($brazalete->load('estatus'));
    }

    public function destroy(Brazalete $brazalete)
    {
        $brazalete->destroy();
        return response()->json([
            'message' => 'Brazalete eliminado'
        ]);

    }

    public function validar(Request $request) 
    {
        $request->validate(['qr_code' => 'required|string']);

        $brazalete = Brazalete::where('qr_code', $request->qr_code)
        ->with('estatus')
        ->first();

        if (!$brazalete) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'Brazalete no Encontrado'
            ], 404);
        }

        return response()->json([
            'valido' => true,
            'brazalete' => $brazalete
        ]);
    }
}