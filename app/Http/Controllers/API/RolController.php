<?php

namespace App\Http\Controllers\API;

use App\Models\Rol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolController extends Controller
{
    // LISTAR TODOS
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    // CREAR
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre'
        ]);

        $rol = Rol::create($request->all());

        return response()->json([
            'message' => 'Rol creado exitosamente.',
            'data' => $rol
        ], 201);
    }

    // MOSTRAR UNO
    public function show($id)
    {
        $rol = Rol::findOrFail($id);
        return response()->json($rol, 200);
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255|unique:roles,nombre,' . $id
        ]);

        $rol->update($request->all());

        return response()->json([
            'message' => 'Rol actualizado exitosamente.',
            'data' => $rol
        ], 200);
    }

    // ELIMINAR
    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return response()->json([
            'message' => 'Rol eliminado exitosamente.'
        ], 200);
    }
}