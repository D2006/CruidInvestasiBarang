<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PermissionController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $currentRole = session('role');

        // Admin can only edit permissions for role 'user'
        if ($currentRole === 'admin' && $user->role !== 'user') {
            return redirect()->route('no.access')->with('error', 'Admin hanya boleh mengatur izin untuk user biasa.');
        }

        // Superadmin can edit any (user or admin)
        return view('users.permissions', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $currentRole = session('role');

        if ($currentRole === 'admin' && $user->role !== 'user') {
            return redirect()->route('no.access')->with('error', 'Admin hanya boleh mengatur izin untuk user biasa.');
        }

        // Superadmin may edit permissions for admin & user
        $user->can_add = $request->has('can_add');
        $user->can_edit = $request->has('can_edit');
        $user->can_delete = $request->has('can_delete');
        $user->save();

        // if editing currently logged-in user, update session
        if (session('user_id') == $user->id) {
            session(['can_add' => (bool)$user->can_add, 'can_edit' => (bool)$user->can_edit, 'can_delete' => (bool)$user->can_delete]);
        }

        return redirect()->route('users.index')->with('success','Permissions berhasil disimpan');
    }
}
