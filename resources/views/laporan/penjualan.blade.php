@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Laporan Penjualan</h3>
            <a href="{{ route('laporan.penjualan.cetak', ['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir]) }}" 
                 target="_blank" class="btn btn-sm btn-secondary">
                <i class="bi bi-printer"></i> Cetak
            </a>

        </div>

        <div class="card-body">
            {{-- Filter Tanggal --}}
            <form method="GET" class="row row-cols-lg-auto g-3 align-items-end mb-4">
                <div class="col">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                        value="{{ $tanggal_awal }}">
                </div>
                <div class="col">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                        value="{{ $tanggal_akhir }}">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                    <a href="{{ route('laporan.penjualan') }}" class="btn btn-secondary ms-2"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="laporanPenjualan">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th style="width:5%">#</th>
                            <th>Nama Pasien</th>
                            <th>Petugas</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total (Rp)</th>
                            <th>Catatan</th>
                            <th>Detail Item</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalPendapatan = 0; @endphp
                        @forelse ($data as $i => $t)
                            @php $totalPendapatan += $t->total; @endphp
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $t->pasien->nama ?? '-' }}</td>
                                <td>{{ $t->user->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                <td>{{ $t->catatan ?? '-' }}</td>
                                <td>
                                    <table class="table table-sm mb-0 border">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>Nama Item</th>
                                                <th class="text-end">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($t->detail as $d)
                                            <tr>
                                                <td>{{ $d->nama_item }}</td>
                                                <td class="text-end">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data penjualan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Total Pendapatan --}}
            <div class="text-end mt-3">
                <h5 class="fw-bold">Total Pendapatan:
                    <span class="text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </h5>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .card, .card * { visibility: visible; }
    .card { position: absolute; left: 0; top: 0; width: 100%; }
    form, .btn { display: none !important; }
}
</style>

<script>
$(function(){
    $('#laporanPenjualan').DataTable({
        paging: true,
        scrollX: true,
        autoWidth: false,
        ordering: false,
        pageLength: 25
    });
});
</script>
@endsection
