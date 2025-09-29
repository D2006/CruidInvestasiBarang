@extends('layouts.app')

@section('content')
<h4>My Items</h4>

{{-- Tombol tambah muncul jika superadmin atau user dengan permission Create --}}
@if(session('role') === 'superadmin' || (session('role') === 'user' && session('can_add')))
  <a href="{{ route('barang.create') }}" class="btn btn-success mb-3">Tambah Barang</a>
@endif

<table class="table table-bordered table-dark" id="myItemsTable">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Jumlah</th>
      <th>Keterangan</th>
      <th>Owner</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($barangs as $b)
    <tr>
      <td>{{ $b->id }}</td>
      <td>{{ $b->nama_barang }}</td>
      <td>{{ $b->jumlah }}</td>
      <td>{{ $b->keterangan }}</td>
      <td>{{ optional($b->owner)->username ?? '-' }}</td>
      <td>
        @php
          $role = session('role');
          $userId = session('user_id');
        @endphp

        {{-- Edit --}}
        @if($role === 'superadmin' || ($role === 'user' && session('can_edit') && $b->owner_id === $userId))
          <a href="{{ route('barang.edit',$b->id) }}" class="btn btn-sm btn-warning">Edit</a>
        @endif

        {{-- Delete --}}
        @if($role === 'superadmin' || ($role === 'user' && session('can_delete') && $b->owner_id === $userId))
          <form action="{{ route('barang.destroy',$b->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus barang?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Hapus</button>
          </form>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
  $('#myItemsTable').DataTable({
    responsive: true,
    pageLength: 10,
    dom: "Bfrtip",
    buttons: [
      { extend: 'copyHtml5', className: 'btn btn-sm btn-outline-light' },
      { extend: 'csvHtml5', className: 'btn btn-sm btn-outline-light' },
      { extend: 'excelHtml5', className: 'btn btn-sm btn-outline-light' },
      { extend: 'pdfHtml5', className: 'btn btn-sm btn-outline-light' },
      { extend: 'print', className: 'btn btn-sm btn-outline-light' }
    ],
    language: { search: "_INPUT_", searchPlaceholder: "Cari..." },
    columnDefs: [{ orderable: false, targets: -1 }]
  });
});
</script>
@endpush
