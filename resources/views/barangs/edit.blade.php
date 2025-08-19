@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm rounded-2">

        <!-- Card Header -->
        <div class="card-header text-white d-flex align-items-center" style="background-color: #0D6EFD;">
          <i class="bi bi-pencil-square fs-4 me-2"></i>
          <h5 class="mb-0">Edit Data Barang</h5>
        </div>

        <!-- Card Body -->
        <div class="card-body" style="background-color: #000000;">
          <form action="{{ route('barangs.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Kode Barang -->
            <div class="mb-3">
              <label class="form-label text-white">Kode Barang</label>
              <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}"
                     class="form-control @error('kode_barang') is-invalid @enderror">
              @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Nama Barang -->
            <div class="mb-3">
              <label class="form-label text-white">Nama Barang</label>
              <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}"
                     class="form-control @error('nama_barang') is-invalid @enderror">
              @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Jumlah -->
            <div class="mb-3">
              <label class="form-label text-white">Jumlah</label>
              <input type="number" name="jumlah" value="{{ old('jumlah', $barang->jumlah) }}"
                     class="form-control @error('jumlah') is-invalid @enderror">
              @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Satuan -->
            <div class="mb-3">
              <label class="form-label text-white">Satuan</label>
              <input type="text" name="satuan" value="{{ old('satuan', $barang->satuan) }}"
                     class="form-control @error('satuan') is-invalid @enderror">
              @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Lokasi -->
            <div class="mb-3">
              <label class="form-label text-white">Lokasi</label>
              <input type="text" name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}"
                     class="form-control @error('lokasi') is-invalid @enderror">
              @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Tombol -->
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('barangs.index') }}" class="btn btn-danger">Batal</a>
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

@push('scripts')
  @if(session('success'))
    <script>
      Swal.fire({
        title: 'Berhasil Diperbarui!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK',
        customClass: { confirmButton: 'btn btn-primary' },
        buttonsStyling: false
      });
    </script>
  @endif
@endpush
