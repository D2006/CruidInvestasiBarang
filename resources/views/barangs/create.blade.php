@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm rounded-2 border-0">

        <!-- Header Biru -->
        <div class="card-header text-white d-flex align-items-center" style="background-color: #0D6EFD;">
          <i class="bi bi-plus-circle-fill fs-4 me-2"></i>
          <h5 class="mb-0">Tambah Data Barang</h5>
        </div>

        <!-- Form Background Hitam -->
        <div class="card-body" style="background-color:#000000;">
          <form action="{{ route('barangs.store') }}" method="POST">
            @csrf

            <!-- Form Group -->
            <div class="mb-3">
              <label for="kode_barang" class="form-label">Kode Barang</label>
              <input type="text" name="kode_barang" id="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" value="{{ old('kode_barang') }}">
              @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="nama_barang" class="form-label">Nama Barang</label>
              <input type="text" name="nama_barang" id="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}">
              @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}">
              @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="satuan" class="form-label">Satuan</label>
              <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" value="{{ old('satuan') }}">
              @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="lokasi" class="form-label">Lokasi</label>
              <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}">
              @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('barangs.index') }}" class="btn btn-danger">Batal</a>
            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
@endsection

@push('styles')
<style>
  /* Style untuk form input */
  .form-control {
    background-color: #ffffff !important; /* putih */
    color: #000000 !important; /* teks hitam */
    border: 1px solid #ced4da;
    box-shadow: none !important;
  }

  .form-control:focus {
    border-color: solid #0D6EFD !important; /* border biru saat focus */
    box-shadow: 0 0 0 0.2rem rgba(13, 109, 253, 0.897) !important;
  }

  /* Label putih */
  label.form-label {
    color: #ffffff;
  }

  .card {
    border: none;
  }

  .btn-primary {
    background-color: #0D6EFD;
    border-color: #0D6EFD;
  }

  .btn-danger {
    background-color: #DC3545;
    border-color: #DC3545;
  }
</style>
@endpush
