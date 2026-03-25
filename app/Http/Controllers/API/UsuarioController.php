<?php

namespace App\Http\Controllers\API;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    // LISTAR TODOS
    public function index()
    {
        return response()->json(Usuario::with('roles')->get(), 200);
    }

    // CREAR
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apaterno' => 'required|string|max:255',
            'amaterno' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'activo' => 'boolean'
        ]);

        $usuario = Usuario::create($request->all());

        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'data' => $usuario
        ], 201);
    }

    // MOSTRAR UNO
    public function show($id)
    {
        $usuario = Usuario::with('roles')->findOrFail($id);
        return response()->json($usuario, 200);
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apaterno' => 'sometimes|required|string|max:255',
            'amaterno' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'activo' => 'boolean'
        ]);

        $usuario->update($request->all());

        return response()->json([
            'message' => 'Usuario actualizado exitosamente.',
            'data' => $usuario
        ], 200);
    }

    // ELIMINAR
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente.'
        ], 200);
    }
}