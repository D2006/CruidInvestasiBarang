<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $currentRole = session('role');

        if ($currentRole === 'superadmin') {
            $users = User::orderBy('created_at','desc')->get();
        } elseif ($currentRole === 'admin') {
            // admin sees only users (not admins)
            $users = User::where('role', 'user')->orderBy('created_at','desc')->get();
        } else {
            return redirect()->route('no.access')->with('error','Hanya Superadmin/Admin yang dapat melihat daftar akun');
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        // only superadmin can access create page in routing/middleware,
        // but double-checking is fine:
        if (session('role') !== 'superadmin') {
            return redirect()->route('no.access')->with('error','Hanya Superadmin yang dapat membuat akun');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validasi input + pesan kustom
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user'
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah dipakai, silakan pilih username lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role harus dipilih.',
        ]);

        // Tentukan permission berdasarkan role
        if ($request->role === 'admin') {
            $canAdd = false;
            $canEdit = false;
            $canDelete = false;
        } else {
            // kalau role = user, ambil checkbox (jika checkbox tidak dicentang, has() false)
            $canAdd = $request->has('can_add');
            $canEdit = $request->has('can_edit');
            $canDelete = $request->has('can_delete');
        }

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'can_add' => $canAdd,
            'can_edit' => $canEdit,
            'can_delete' => $canDelete,
        ]);

        return redirect()->route('users.index')->with('success','User berhasil dibuat');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'superadmin') {
            return back()->with('error','Tidak bisa menghapus superadmin');
        }
        $user->delete();
        return back()->with('success','User berhasil dihapus');
    }
}
