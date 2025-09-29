<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Inventaris Barang</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

  <style>
    :root { --bs-primary: rgb(241,9,241); --bs-primary-rgb:128,0,128; }
    body { background-color: #121212; color: #e9ecef; padding-top: 20px; }
    .navbar .nav-link { color: rgba(255,255,255,0.9); }
    .navbar .nav-link:hover { color: #fff; }
    .btn-outline-light { color: #f8f9fa; border-color: rgba(255,255,255,0.15); }
    .card.bg-secondary { background-color: #343a40 !important; }
    table.table-dark { background-color: #1e1e1e; }
  </style>

  @stack('styles')
</head>
<body class="bg-dark text-light">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <div class="container-fluid px-0">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Inventaris</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            {{-- Kelola Akun / Kelola Izin User: superadmin & admin --}}
            @if(in_array(session('role'), ['superadmin','admin']))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                  @if(session('role') === 'admin') Kelola Izin User @else Kelola Akun @endif
                </a>
              </li>
            @endif

            {{-- Barang: tampil untuk semua roles --}}
            @if(in_array(session('role'), ['superadmin','admin','user']))
              <li class="nav-item"><a class="nav-link" href="{{ route('barang.index') }}">Lihat Barang</a></li>
            @endif

            {{-- My Items: tampil untuk user dan superadmin --}}
            @if(in_array(session('role'), ['user','superadmin']))
              <li class="nav-item"><a class="nav-link" href="{{ route('barang.my') }}">My Items</a></li>
            @endif
          </ul>

          <div class="d-flex align-items-center">
            @if(session('username'))
              <span class="me-3 small">Hi, <strong>{{ session('username') }}</strong> (<em>{{ session('role') }}</em>)</span>
              <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Logout</a>
            @else
              {{-- no login link as requested --}}
            @endif
          </div>
        </div>
      </div>
    </nav>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- Buttons extension + deps -->
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

  @stack('scripts')
</body>
</html>

