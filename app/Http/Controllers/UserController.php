<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'profile'])->get();
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|unique:users',
            'password' => 'required',
            'id_role' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        $user = User::create([
            'user_id' => $request->user_id,
            'password' => $request->password,
            'id_role' => $request->id_role,
        ]);

        $profile = Profile::create([
            'id_user' => $user->id_user,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required',
            'id_role' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        $user->update([
            'password' => $request->password,
            'id_role' => $request->id_role,
        ]);

        $user->profile->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->profile->delete();
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function login(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();

        if ($user && $user->password === $request->password) {
            // Store id_user and id_role in cookies
            Cookie::queue('user_id', $user->user_id);
            Cookie::queue('id_role', $user->id_role);
            Cookie::queue('nama_role', $user->role->nama_role);

            // Start a session for the authenticated user
            $request->session()->regenerate();

            return redirect()->route('posts.indexHome');
        }

        return redirect()->back()->with('error', 'User_ID atau Password Salah');
    }

    public function logout()
    {
        // Remove id_user and id_role cookies
        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('id_role'));
        Cookie::queue(Cookie::forget('nama_role'));

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }
}
