<?php

namespace App\Http\Controllers\API;

use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InscripcionController extends Controller
{
    public function index()
    {
        return response()->json(Inscripcion::with(['estudiante', 'grupo'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:usuarios,id',
            'grupo_id' => 'required|exists:grupos,id',
            'ciclo_escolar' => 'required|string|max:50'
        ]);

        $inscripcion = Inscripcion::create($request->all());

        return response()->json([
            'message' => 'Inscripción creada exitosamente.',
            'data' => $inscripcion
        ], 201);
    }

    public function show($id)
    {
        $inscripcion = Inscripcion::with(['estudiante', 'grupo'])->findOrFail($id);
        return response()->json($inscripcion, 200);
    }

    public function update(Request $request, $id)
    {
        $inscripcion = Inscripcion::findOrFail($id);

        $request->validate([
            'estudiante_id' => 'sometimes|required|exists:usuarios,id',
            'grupo_id' => 'sometimes|required|exists:grupos,id',
            'ciclo_escolar' => 'sometimes|required|string|max:50'
        ]);

        $inscripcion->update($request->all());

        return response()->json([
            'message' => 'Inscripción actualizada exitosamente.',
            'data' => $inscripcion
        ], 200);
    }

    public function destroy($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $inscripcion->delete();

        return response()->json([
            'message' => 'Inscripción eliminada exitosamente.'
        ], 200);
    }
}