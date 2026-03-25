<?php

namespace App\Http\Controllers\API;

use App\Models\Calificacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalificacionController extends Controller
{
    public function index()
    {
        return response()->json(Calificacion::with(['estudiante', 'materia', 'grupo'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:usuarios,id',
            'materia_id' => 'required|exists:materias,id',
            'grupo_id' => 'required|exists:grupos,id',
            'parcial1' => 'nullable|numeric|min:0|max:100',
            'parcial2' => 'nullable|numeric|min:0|max:100',
            'parcial3' => 'nullable|numeric|min:0|max:100',
            'promedio' => 'nullable|numeric|min:0|max:100',
        ]);

        $calificacion = Calificacion::create($request->all());

        return response()->json([
            'message' => 'Calificación creada exitosamente.',
            'data' => $calificacion
        ], 201);
    }

    public function show($id)
    {
        $calificacion = Calificacion::with(['estudiante', 'materia', 'grupo'])->findOrFail($id);
        return response()->json($calificacion, 200);
    }

    public function update(Request $request, $id)
    {
        $calificacion = Calificacion::findOrFail($id);

        $request->validate([
            'estudiante_id' => 'sometimes|required|exists:usuarios,id',
            'materia_id' => 'sometimes|required|exists:materias,id',
            'grupo_id' => 'sometimes|required|exists:grupos,id',
            'parcial1' => 'nullable|numeric|min:0|max:100',
            'parcial2' => 'nullable|numeric|min:0|max:100',
            'parcial3' => 'nullable|numeric|min:0|max:100',
            'promedio' => 'nullable|numeric|min:0|max:100',
        ]);

        $calificacion->update($request->all());

        return response()->json([
            'message' => 'Calificación actualizada exitosamente.',
            'data' => $calificacion
        ], 200);
    }

    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();

        return response()->json([
            'message' => 'Calificación eliminada exitosamente.'
        ], 200);
    }
}