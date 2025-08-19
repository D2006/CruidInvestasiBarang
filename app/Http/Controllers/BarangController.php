<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::orderBy('created_at', 'desc')->paginate(10);
        return view('barangs.index', compact('barangs'));
    }

    public function create()
    {
        return view('barangs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs|max:5000',
            'nama_barang' => 'required',
            'jumlah'      => 'required|integer',
            'satuan'      => 'required',
            'lokasi'      => 'required',
        ]);

        Barang::create($validated);
        return redirect()->route('barangs.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        return view('barangs.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'jumlah'      => 'required|integer',
            'satuan'      => 'required',
            'lokasi'      => 'required',
        ]);

        $barang->update($validated);
        return redirect()->route('barangs.index')
            ->with('success', 'Data barang berhasil diubah.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return back()->with('success', 'Data barang berhasil dihapus.');
    }
}