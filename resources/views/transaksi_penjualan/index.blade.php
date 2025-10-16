@extends('layouts.app')
@section('title', 'Transaksi Penjualan')

@section('content')
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Transaksi Penjualan</h3>
            <a href="{{ route('transaksi-penjualan.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Transaksi
            </a>
        </div>
        <div class="card-body">
            <div style="overflow-x:auto;">
                <table id="transaksi" class="table table-bordered table-hover nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Pemeriksaan</th>
                            <th>Total</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $i => $t)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $t->pasien->nama ?? '-' }}</td>
                            <td>#{{ $t->pemeriksaan->id ?? '-' }}</td>
                            <td>Rp {{ number_format($t->total,0,',','.') }}</td>
                            <td>{{ $t->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){ $('#transaksi').DataTable({scrollX:true,autoWidth:false}); });
</script>
@endsection
