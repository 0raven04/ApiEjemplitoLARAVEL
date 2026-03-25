<?php

namespace App\Http\Controllers\API;

use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarreraController extends Controller
{
    public function index()
    {
        return response()->json(Carrera::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $carrera = Carrera::create($request->all());

        return response()->json([
            'message' => 'Carrera creada exitosamente.',
            'data' => $carrera
        ], 201);
    }

    public function show($id)
    {
        $carrera = Carrera::findOrFail($id);
        return response()->json($carrera, 200);
    }

    public function update(Request $request, $id)
    {
        $carrera = Carrera::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $carrera->update($request->all());

        return response()->json([
            'message' => 'Carrera actualizada exitosamente.',
            'data' => $carrera
        ], 200);
    }

    public function destroy($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->delete();
        
        return response()->json([
            'message' => 'Carrera eliminada exitosamente.'
        ], 200);
    }
}