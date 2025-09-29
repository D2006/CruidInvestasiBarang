@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-4">
    <h4 class="mb-3">Login</h4>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="post">
      @csrf
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" class="form-control" required value="{{ old('username') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</div>
@endsection
