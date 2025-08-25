<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brazalete;
use App\Models\Evento;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BrzaleteController extends Controller
{
    public function index()
    {
        return BrazaleteResource::collection(Brazalete::all());
    }

    public function store()
    {
        $brazalete = Brazalete::create($request->validated());
        return new BrazaleteResource($brazalete);
    }

    public function update(Request $request, Brazalete $brazalete)
    {
        $brazalete-update($request->all());
        return new BrazaleteResource($brazalete);
    }

    public function destroy(Brazalete $brazalete)
    {
        $brazalete->delete();
        return response()->onContent();
    }
}