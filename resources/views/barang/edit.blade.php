@extends('layouts.app')
@section('content')
<h4>Edit Barang</h4>
<form method="POST" action="{{ route('barang.update', $barang->id) }}">
  @csrf
  @method('PUT')
  <div class="mb-3">
    <label>Nama Barang</label>
    <input name="nama_barang" class="form-control" required value="{{ $barang->nama_barang }}">
  </div>
  <div class="mb-3">
    <label>Jumlah</label>
    <input name="jumlah" type="number" class="form-control" required value="{{ $barang->jumlah }}">
  </div>
  <div class="mb-3">
    <label>Keterangan</label>
    <textarea name="keterangan" class="form-control">{{ $barang->keterangan }}</textarea>
  </div>
  <button class="btn btn-primary">Update</button>
</form>
@endsection
