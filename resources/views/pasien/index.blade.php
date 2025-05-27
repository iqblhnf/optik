@extends('layouts.app')

@section('title', 'Pasien')

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
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Pasien</h3>
                    <a href="{{ route('pasien.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Pasien
                    </a>
                </div>
                <div class="card-body">
                    <div style="overflow-x: auto;">
                        <table id="pasien" class="table table-bordered table-hover align-middle nowrap" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Nama</th>
                                    <th>Usia</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pekerjaan</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $index => $pasien)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pasien->nama }}</td>
                                    <td>{{ $pasien->usia }}</td>
                                    <td>{{ $pasien->jenis_kelamin }}</td>
                                    <td>{{ $pasien->pekerjaan }}</td>
                                    <td>{{ $pasien->alamat }}</td>
                                    <td>{{ $pasien->no_telp }}</td>
                                    <td>
                                        <a href="{{ route('pasien.edit', $pasien->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Gaya dan Script DataTables --}}
<style>
    table.dataTable td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        overflow-x: auto;
    }
</style>

<script>
    $(document).ready(function() {
        $('#pasien').DataTable({
            scrollX: true,
            autoWidth: false
        });
    });
</script>
@endsection
