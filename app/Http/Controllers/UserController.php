<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los usuarios
        $users = User::all(); // Asegúrate de que esto obtenga los usuarios correctamente

        // Retornar la vista con los usuarios
        return Inertia::render('usuarios/index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('usuarios/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el nuevo usuario
        User::create([
            'name' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Redirigir a la lista de usuarios con mensaje de éxito
        return to_route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
    
        return Inertia::render('usuarios/edit', compact('usuario'));
    }
    
    public function update(Request $request, User $usuario)
    {
        // Validar los datos de la solicitud
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed', // Asegúrate de que sea opcional
        ]);
    
        // Actualizar el usuario
        $usuario->name = $validated['nombre'];
        $usuario->email = $validated['email'];
    
        // Actualizar la contraseña solo si se proporciona
        if ($request->filled('password')) {
            $usuario->password = bcrypt($validated['password']);
        }
    
        $usuario->save();
    
        // Redirigir a la lista de usuarios con mensaje de éxito
        return to_route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();

        return to_route('usuarios.index')->with('success', 'Usuario eliminado con éxito.');
    }
}
