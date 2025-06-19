<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {   
        $roles = auth()->user()->hasRole('moderador') 
            ? Role::where('name', '!=', 'admin')->get() 
            : Role::all();

        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $rolesPermitidos = auth()->user()->hasRole('moderador') 
            ? Role::where('name', '!=', 'admin')->pluck('name')->toArray()
            : Role::pluck('name')->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:' . implode(',', $rolesPermitidos),
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $usuario)
    {
        if ($usuario->hasRole('admin') && !auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para editar un administrador.');
        }
        
        $roles = auth()->user()->hasRole('moderador')
            ? Role::where('name', '!=', 'admin')->get()
            : Role::all();

        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        if ($usuario->hasRole('admin') && !auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para actualizar un administrador.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$usuario->id}",
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->save();

        $usuario->syncRoles($request->role);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->hasRole('admin') && !auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para eliminar un administrador.');
        }   
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
