@extends('layouts.app')
@section('title', 'Rekap Stok Barang')

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
            <h3 class="card-title">Rekap Stok Barang</h3>
            <a href="{{ route('barang.index') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-box-seam"></i> Kelola Barang
            </a>
        </div>
        <div class="card-body">
            <div style="overflow-x:auto;">
                <table id="stok" class="table table-bordered table-hover align-middle nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Total Masuk</th>
                            <th>Total Keluar</th>
                            <th>Stok Sistem</th>
                            <th>Stok Akhir (Hitung)</th>
                            <th>Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $i => $b)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $b['kode'] }}</td>
                            <td>{{ $b['nama'] }}</td>
                            <td>{{ $b['kategori'] }}</td>
                            <td>{{ $b['satuan'] }}</td>
                            <td>{{ $b['total_masuk'] }}</td>
                            <td>{{ $b['total_keluar'] }}</td>
                            <td>{{ $b['stok_tercatat'] }}</td>
                            <td>{{ $b['stok_akhir'] }}</td>
                            <td>
                                @php $selisih = $b['stok_akhir'] - $b['stok_tercatat']; @endphp
                                <span class="{{ $selisih == 0 ? 'text-success' : 'text-danger fw-bold' }}">
                                    {{ $selisih }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
    $('#stok').DataTable({
        scrollX: true,
        autoWidth: false,
        order: [[1, 'asc']]
    });
});
</script>
@endsection
