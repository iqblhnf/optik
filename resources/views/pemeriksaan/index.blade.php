@extends('layouts.app')

@section('title', 'Pemeriksaan')

@section('content')
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Pemeriksaan</h3>
            <a href="{{ route('pemeriksaan.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i> Tambah</a>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table id="pemeriksaan" class="table table-bordered table-hover align-middle nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pasien</th>
                            <th>Usia</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Terakhir Pemeriksaan</th>
                            <th>Jumlah Pemeriksaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->usia }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->terakhir_pemeriksaan ? \Carbon\Carbon::parse($item->terakhir_pemeriksaan)->translatedFormat('d M Y H:i:s') : '-' }}</td>
                            <td>{{ $item->jumlah_pemeriksaan }}</td>
                            <td>
                                <!-- tombol aksi, bisa ambil data pemeriksaan terakhir -->
                                <a href="{{ route('pemeriksaan.riwayat', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-clock-history"></i> Riwayat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Membuat konten kolom tidak terpotong dan melebar sesuai isi */
    table.dataTable td {
        white-space: nowrap;
    }

    /* Memastikan scroll horizontal aktif */
    div.dataTables_wrapper {
        width: 100%;
        overflow-x: auto;
    }
</style>

<script>
    $(document).ready(function() {
        $('#pemeriksaan').DataTable({
            scrollX: true,
            autoWidth: false
        });
    });
</script>
@endsection