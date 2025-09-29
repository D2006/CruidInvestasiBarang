<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username'=>'required|string',
            'password'=>'required|string'
        ]);

        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error','Username atau password salah')->withInput();
        }

        session()->regenerate();
        session([
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'can_add' => (bool)$user->can_add,
            'can_edit' => (bool)$user->can_edit,
            'can_delete' => (bool)$user->can_delete,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
