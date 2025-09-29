@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Daftar Akun</h4>

  @if(session('role') === 'superadmin')
    <a href="{{ route('users.create') }}" class="btn btn-success">Tambah Akun</a>
  @endif
</div>

<div class="table-responsive">
  <table class="table table-dark table-striped table-bordered" id="usersTable">
    <thead>
      <tr>
        <th>ID</th><th>Username</th><th>Role</th><th>Create</th><th>Edit</th><th>Delete</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $u)
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $u->username }}</td>
          <td>{{ $u->role }}</td>
          <td class="text-center">{{ $u->can_add ? '✔' : '✖' }}</td>
          <td class="text-center">{{ $u->can_edit ? '✔' : '✖' }}</td>
          <td class="text-center">{{ $u->can_delete ? '✔' : '✖' }}</td>
          <td>
            <div class="d-flex gap-1">
              @if(in_array(session('role'), ['superadmin','admin']) && $u->role === 'user')
                <a href="{{ route('users.permissions.edit', $u->id) }}" class="btn btn-sm btn-warning">Kelola Izin</a>
              @endif

              @if(session('role') === 'superadmin' && $u->role !== 'superadmin')
                <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              @endif
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
  $('#usersTable').DataTable({
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
    language: { search: "_INPUT_", searchPlaceholder: "Cari akun..." },
    columnDefs: [{ orderable: false, targets: -1 }]
  });
});
</script>
@endpush
