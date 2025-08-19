@extends('layouts.app')

@push('styles')
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <style>


  
    table.dataTable thead th {
      background-color: #000000 !important;
      color: #fff;
    }

    /* Search ke kanan */
    .dataTables_filter {
      text-align: right !important;
    }
  </style>
@endpush

@section('content')
  <h1 class="mb-4">Data Barang</h1>

  <a href="{{ route('barangs.create') }}" class="btn btn-primary mb-3">
    Tambah Barang
  </a>

  <div class="table-responsive">
    <table id="barangTable" class="table table-dark table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Lokasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($barangs as $b)
          <tr>
            <td>{{ $b->kode_barang }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->jumlah }}</td>
            <td>{{ $b->satuan }}</td>
            <td>{{ $b->lokasi }}</td>
            <td>
              <a href="{{ route('barangs.edit', $b) }}" class="btn btn-sm btn-primary me-1">
                Edit
              </a>

              <form action="{{ route('barangs.destroy', $b) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin hapus?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

@push('scripts')
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#barangTable').DataTable({
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Cari data barang..."
        }
      });
    });
  </script>
@endpush
