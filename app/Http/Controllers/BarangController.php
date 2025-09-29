<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\User;

class BarangController extends Controller
{
    // Tampilkan semua barang (semua role bisa melihat)
    public function index(Request $request)
    {
        $barangs = Barang::with('owner')->orderBy('id','desc')->get();
        return view('barang.index', compact('barangs'));
    }

    // Tampilkan barang milik user yang login (My Items)
    public function myItems(Request $request)
    {
        $userId = $request->session()->get('user_id');

        // Ambil barang milik user ini saja
        $barangs = Barang::with('owner')
            ->where('owner_id', $userId)
            ->orderBy('created_at','desc')
            ->get();

        return view('barang.myitems', compact('barangs'));
    }

    // Form create barang
    public function create(Request $request)
    {
        $role = $request->session()->get('role');
        $canCreate = (bool) $request->session()->get('can_add', false);

        // Superadmin always allowed. User allowed if permission. Admin not allowed.
        if (!($role === 'superadmin' || ($role === 'user' && $canCreate))) {
            return back()->with('error','Anda tidak punya izin menambah barang');
        }

        return view('barang.create');
    }

    // Store barang
    public function store(Request $request)
    {
        $role = $request->session()->get('role');
        $canCreate = (bool) $request->session()->get('can_add', false);

        if (!($role === 'superadmin' || ($role === 'user' && $canCreate))) {
            return back()->with('error','Anda tidak punya izin menambah barang');
        }

        $request->validate([
            'nama_barang' => 'required|string',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $ownerId = $request->session()->get('user_id');

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'owner_id' => $ownerId,
        ]);

        return redirect()->route('barang.index')->with('success','Barang berhasil ditambahkan');
    }

    // Form edit
    public function edit(Request $request, $id)
    {
        $role = $request->session()->get('role');
        $canEdit = (bool) $request->session()->get('can_edit', false);
        $userId = $request->session()->get('user_id');

        $barang = Barang::findOrFail($id);

        if ($role === 'superadmin') {
            return view('barang.edit', compact('barang'));
        }

        if ($role === 'admin') {
            return back()->with('error','Admin tidak memiliki izin mengedit barang');
        }

        if ($role === 'user' && $canEdit && $barang->owner_id === $userId) {
            return view('barang.edit', compact('barang'));
        }

        return back()->with('error','Anda tidak punya izin mengedit barang ini');
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $role = $request->session()->get('role');
        $canEdit = (bool) $request->session()->get('can_edit', false);
        $userId = $request->session()->get('user_id');

        $barang = Barang::findOrFail($id);

        if ($role === 'superadmin') {
            // allowed
        } elseif ($role === 'admin') {
            return back()->with('error','Admin tidak memiliki izin mengedit barang');
        } elseif (!($role === 'user' && $canEdit && $barang->owner_id === $userId)) {
            return back()->with('error','Anda tidak punya izin mengedit barang ini');
        }

        $request->validate([
            'nama_barang' => 'required|string',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $barang->update($request->only(['nama_barang','jumlah','keterangan']));

        return redirect()->route('barang.index')->with('success','Barang berhasil diperbarui');
    }

    // Hapus barang
    public function destroy(Request $request, $id)
    {
        $role = $request->session()->get('role');
        $canDelete = (bool) $request->session()->get('can_delete', false);
        $userId = $request->session()->get('user_id');

        $barang = Barang::findOrFail($id);

        if ($role === 'superadmin') {
            // allowed
        } elseif ($role === 'admin') {
            return back()->with('error','Admin tidak memiliki izin menghapus barang');
        } elseif (!($role === 'user' && $canDelete && $barang->owner_id === $userId)) {
            return back()->with('error','Anda tidak punya izin menghapus barang ini');
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success','Barang berhasil dihapus');
    }
}
