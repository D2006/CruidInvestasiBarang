@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
  {{-- Header --}}
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="mb-1">Dashboard Inventaris</h2>
      <small class="text-muted">Halo, <strong>{{ session('username') ?? 'User' }}</strong> — Role: <em>{{ session('role') ?? 'guest' }}</em></small>
    </div>

    <div class="d-flex gap-2">
      @if(session('role') === 'superadmin')
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">+ Tambah Akun</a>
        <a href="{{ route('barang.create') }}" class="btn btn-success shadow-sm">+ Tambah Barang</a>
      @elseif(session('role') === 'user' && session('can_add'))
        <a href="{{ route('barang.create') }}" class="btn btn-success shadow-sm">+ Tambah Barang</a>
      @endif
    </div>
  </div>

  {{-- Cards --}}
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card h-100 card-soft">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM6 20c0-2.21 3.58-4 6-4s6 1.79 6 4v1H6v-1z" fill="white"/></svg>
              </div>
            </div>
            <div>
              <small class="text-muted">Total Users</small>
              <h5 class="mb-0">{{ $totalUsers }}</h5>
              <small class="text-muted">Admin: {{ $totalAdmins }} • Super: {{ $totalSuperadmins }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="card h-100 card-soft">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M3 13h2v-2H3v2zm0 6h2v-2H3v2zM3 7h2V5H3v2zM7 13h2v-2H7v2zm0 6h2v-2H7v2zM7 7h2V5H7v2zm4 6h2v-2h-2v2zm0 6h2v-2h-2v2zM11 7h2V5h-2v2zm4 6h6v-2h-6v2zm0 6h6v-2h-6v2z" fill="white"/></svg>
              </div>
            </div>
            <div>
              <small class="text-muted">Total Barang</small>
              <h5 class="mb-0">{{ $totalItems }}</h5>
              <small class="text-muted">My Items: {{ $myItems }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="card h-100 card-soft">
        <div class="card-body">
          <small class="text-muted">Permissions</small>
          <div class="mt-2">
            @if(session('role') === 'user')
              <span class="badge bg-success me-1">Create: {{ session('can_add') ? 'Yes' : 'No' }}</span>
              <span class="badge bg-warning text-dark me-1">Edit: {{ session('can_edit') ? 'Yes' : 'No' }}</span>
              <span class="badge bg-danger">Delete: {{ session('can_delete') ? 'Yes' : 'No' }}</span>
            @else
              <span class="text-muted">Permissions dapat diatur oleh Superadmin/Admin</span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="card h-100 card-soft">
        <div class="card-body">
          <small class="text-muted">Quick Links</small>
          <div class="mt-2 d-flex flex-column gap-2">
            <a href="{{ route('barang.index') }}" class="btn btn-outline-light btn-sm">Lihat Semua Barang</a>
            @if(in_array(session('role'), ['superadmin','admin']))
              <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-sm">Kelola Akun / Izin</a>
            @endif
            @if(session('role') === 'user' || session('role') === 'superadmin')
              <a href="{{ route('barang.my') }}" class="btn btn-outline-light btn-sm">My Items</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Charts & Recent --}}
  <div class="row g-3">
    <div class="col-12 col-lg-6">
      <div class="card card-soft h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            {{-- Title: beri class agar warnanya kontras --}}
            <h5 class="mb-0 chart-title">Distribusi Barang menurut Role Pemilik</h5>
            <small class="text-muted">total {{ $totalItems }} items</small>
          </div>

          <div style="position:relative; height:320px;">
            <canvas id="itemsRoleChart"></canvas>
          </div>

          <div class="mt-3 d-flex gap-3 chart-legend">
            {{-- Only show legend rows for roles that actually exist in the chart data --}}
            @foreach($chartLabels as $idx => $label)
              <span class="d-flex align-items-center legend-row">
                <span class="badge legend-color me-2" style="background: {{ $chartColors[$idx] ?? '#888' }}">&nbsp;&nbsp;</span>
                <span class="legend-label">{{ $label }}</span>
              </span>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="card card-soft h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Barang Terbaru</h5>
            <a href="{{ route('barang.index') }}" class="small text-decoration-none text-muted">Lihat semua</a>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-sm mb-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Jumlah</th>
                  <th>Owner</th>
                  <th>Waktu</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentItems as $it)
                  <tr>
                    <td class="text-muted">{{ $it->id }}</td>
                    <td class="text-light">{{ $it->nama_barang }}</td>
                    <td class="text-muted">{{ $it->jumlah }}</td>
                    <td class="text-muted">{{ optional($it->owner)->username ?? '-' }}</td>
                    <td><small class="text-muted">{{ $it->created_at->format('Y-m-d H:i') }}</small></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada barang</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- Footer small tips --}}
  <div class="mt-4">
    <div class="card card-soft">
      <div class="card-body small text-muted">
        Tips: tombol dan tampilan hanya memudahkan — semua cek izin tetap dilakukan di server. Jika kamu admin dan ingin mengizinkan user buat barang, buka <strong>Kelola Izin</strong>.
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  /* minor styling */
  .card-soft { background: #1f2126; border-radius: 12px; border: none; }
  .bg-purple { background: linear-gradient(135deg,#a84ce6,#f109f1); }

  /* Pastikan title dan legend selalu terlihat pada tema gelap */
  .chart-title { color: #e6eef6; font-weight:600; }
  .chart-legend .legend-row { color: #bfc6cf; align-items:center; }
  .legend-label { color: #bfc6cf; font-weight:500; }
  .legend-color { width:18px; height:18px; border-radius:4px; display:inline-block; vertical-align:middle; }

  /* fallback untuk teks tabel */
  .text-muted { color: #bfc6cf !important; }
  .card .card-body small { color: #bfc6cf; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const chartLabels = {!! json_encode($chartLabels) !!};
  const chartData   = {!! json_encode($chartData) !!};
  const chartColors = {!! json_encode($chartColors) !!};

  // if no data, replace canvas with a friendly message
  if (!chartLabels || chartLabels.length === 0) {
    const ctx = document.getElementById('itemsRoleChart');
    if (ctx) {
      ctx.parentElement.innerHTML = '<div class="h-100 d-flex align-items-center justify-content-center text-muted">Tidak ada data item untuk ditampilkan pada chart.</div>';
    }
    return;
  }

  const data = {
    labels: chartLabels,
    datasets: [{
      data: chartData,
      backgroundColor: chartColors,
      hoverOffset: 8,
      borderWidth: 0
    }]
  };

  const config = {
    type: 'doughnut',
    data,
    options: {
      plugins: {
        legend: { display: false },
        tooltip: { mode: 'index' }
      },
      maintainAspectRatio: false,
      cutout: '60%'
    }
  };

  const ctx = document.getElementById('itemsRoleChart').getContext('2d');
  new Chart(ctx, config);
});
</script>
@endpush
