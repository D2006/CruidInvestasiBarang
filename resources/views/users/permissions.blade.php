@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h4>Kelola Izin: <strong>{{ $user->username }}</strong></h4>

    <form action="{{ route('users.permissions.update', $user->id) }}" method="POST">
      @csrf

      <table class="table table-dark table-bordered">
        <thead>
          <tr><th>Permission</th><th class="text-center">Aktif</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>Create</td>
            <td class="text-center"><input type="checkbox" name="can_add" value="1" {{ $user->can_add ? 'checked' : '' }}></td>
          </tr>
          <tr>
            <td>Edit</td>
            <td class="text-center"><input type="checkbox" name="can_edit" value="1" {{ $user->can_edit ? 'checked' : '' }}></td>
          </tr>
          <tr>
            <td>Delete</td>
            <td class="text-center"><input type="checkbox" name="can_delete" value="1" {{ $user->can_delete ? 'checked' : '' }}></td>
          </tr>
        </tbody>
      </table>

      <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan Izin</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
