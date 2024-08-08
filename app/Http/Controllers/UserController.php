<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'user');
        })->get();
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.role-permission.user.index', compact('roles', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'phone' => 'required|string|max:13',
            'address' => 'required'
        ],
            [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name field must be a string.',
                'name.max' => 'The name field must not exceed 255 characters.',
            ]);
        $data = $request->only(['name', 'email', 'password', 'phone', 'address']);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = User::create($data);
        $user->syncRoles([$request->role]);


        if ($user->hasRole('user')) {
            return redirect()->route('home');
        } else {
            return redirect()->route('users.index')->with('success', 'User created successfully');
        }

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|required',
            'role' => 'required',
            'phone' => 'required|string|max:13',
            'address' => 'required'
        ]);
        $data = $request->only(['name', 'email', 'phone', 'address']);


        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }


        $user->update($data);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)

    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
    public function clients(){
        $users=User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();
        return view('admin.role-permission.user.client', compact('users'));
    }


}
