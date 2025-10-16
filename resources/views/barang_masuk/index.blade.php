@extends('layouts.app')
@section('title', 'Barang Masuk')

@section('content')
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@if(session('error'))
<div class="container mt-3">
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Barang Masuk</h3>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahMasuk">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>
        <div class="card-body">
            <table id="masuk" class="table table-bordered table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $row)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal_masuk)->format('d/m/Y') }}</td>
                        <td>{{ $row->barang->nama_barang }}</td>
                        <td>{{ $row->jumlah }}</td>
                        <td>{{ $row->keterangan }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>
                            <form action="{{ route('barang-masuk.destroy',$row->id) }}" method="POST"
                                onsubmit="return confirm('Hapus data ini?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahMasuk" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('barang-masuk.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Barang</label>
                    <select name="barang_id" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                        <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function(){ $('#masuk').DataTable({scrollX:true,autoWidth:false}); });
</script>
@endsection
