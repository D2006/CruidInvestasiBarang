@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h4>Tambah Akun</h4>

    {{-- Tampilkan pesan sukses / error umum --}}
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Jika ada error validasi, tampilkan ringkasan --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        @error('username')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
        @error('password')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" id="roleSelect" class="form-select" required>
          <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>User</option>
        </select>
        @error('role')
          <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
      </div>

      <h6 class="mt-3">Default Permissions (hanya berlaku untuk role = user)</h6>

      <div class="form-check">
        <input class="form-check-input perm-checkbox" type="checkbox" name="can_add" id="can_add"
               {{ old('can_add', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="can_add">Create</label>
      </div>

      <div class="form-check">
        <input class="form-check-input perm-checkbox" type="checkbox" name="can_edit" id="can_edit"
               {{ old('can_edit', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="can_edit">Edit</label>
      </div>

      <div class="form-check">
        <input class="form-check-input perm-checkbox" type="checkbox" name="can_delete" id="can_delete"
               {{ old('can_delete', true) ? 'checked' : '' }}>
        <label class="form-check-label" for="can_delete">Delete</label>
      </div>

      <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const roleSelect = document.getElementById('roleSelect');
  const permCheckboxes = document.querySelectorAll('.perm-checkbox');

  function updatePerms() {
    if (roleSelect.value === 'admin') {
      permCheckboxes.forEach(cb => { cb.checked = false; cb.disabled = true; });
    } else {
      permCheckboxes.forEach(cb => { cb.disabled = false; });
    }
  }

  roleSelect.addEventListener('change', updatePerms);
  updatePerms();
});
</script>
@endpush
