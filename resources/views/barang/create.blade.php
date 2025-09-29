@extends('layouts.app')
@section('content')
<h4>Tambah Barang</h4>
<form method="POST" action="{{ route('barang.store') }}">
  @csrf
  <div class="mb-3">
    <label>Nama Barang</label>
    <input name="nama_barang" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Jumlah</label>
    <input name="jumlah" type="number" class="form-control" required value="0">
  </div>
  <div class="mb-3">
    <label>Keterangan</label>
    <textarea name="keterangan" class="form-control"></textarea>
  </div>
  <button class="btn btn-success">Simpan</button>
</form>
@endsection
