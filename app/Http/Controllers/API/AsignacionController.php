<?php

namespace App\Http\Controllers\API;

use App\Models\Asignacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsignacionController extends Controller
{
    public function index()
    {
        return response()->json(Asignacion::with(['docente', 'materia', 'grupo'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:usuarios,id',
            'materia_id' => 'required|exists:materias,id',
            'grupo_id' => 'required|exists:grupos,id'
        ]);

        $asignacion = Asignacion::create($request->all());

        return response()->json([
            'message' => 'Asignación creada exitosamente.',
            'data' => $asignacion
        ], 201);
    }

    public function show($id)
    {
        $asignacion = Asignacion::with(['docente', 'materia', 'grupo'])->findOrFail($id);
        return response()->json($asignacion, 200);
    }

    public function update(Request $request, $id)
    {
        $asignacion = Asignacion::findOrFail($id);

        $request->validate([
            'docente_id' => 'sometimes|required|exists:usuarios,id',
            'materia_id' => 'sometimes|required|exists:materias,id',
            'grupo_id' => 'sometimes|required|exists:grupos,id'
        ]);

        $asignacion->update($request->all());

        return response()->json([
            'message' => 'Asignación actualizada exitosamente.',
            'data' => $asignacion
        ], 200);
    }

    public function destroy($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->delete();

        return response()->json([
            'message' => 'Asignación eliminada exitosamente.'
        ], 200);
    }
}