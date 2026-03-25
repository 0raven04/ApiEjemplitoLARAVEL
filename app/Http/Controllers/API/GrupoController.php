<?php

namespace App\Http\Controllers\API;

use App\Models\Grupo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GrupoController extends Controller
{
    public function index()
    {
        return response()->json(Grupo::with('carrera')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'semestre' => 'required|string|max:50',
            'carrera_id' => 'required|exists:carreras,id'
        ]);

        $grupo = Grupo::create($request->all());

        return response()->json([
            'message' => 'Grupo creado exitosamente.',
            'data' => $grupo
        ], 201);
    }

    public function show($id)
    {
        $grupo = Grupo::with('carrera')->findOrFail($id);
        return response()->json($grupo, 200);
    }

    public function update(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'semestre' => 'sometimes|required|string|max:50',
            'carrera_id' => 'sometimes|required|exists:carreras,id'
        ]);

        $grupo->update($request->all());

        return response()->json([
            'message' => 'Grupo actualizado exitosamente.',
            'data' => $grupo
        ], 200);
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->delete();

        return response()->json([
            'message' => 'Grupo eliminado exitosamente.'
        ], 200);
    }
}