@extends('layouts.app')
@section('title', 'Barang Keluar')

@section('content')
{{-- Alert Sukses --}}
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

{{-- Alert Error --}}
@if(session('error'))
<div class="container mt-3">
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif


<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Barang Keluar</h3>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKeluar">
                <i class="bi bi-plus-circle"></i> Tambah
            </button>
        </div>

        <div class="card-body">
            <table id="keluar" class="table table-bordered table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tujuan</th>
                        <th>Gambar</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $index => $row)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal_keluar)->format('d/m/Y') }}</td>
                        <td>{{ $row->barang->nama_barang }}</td>
                        <td>{{ $row->jumlah }}</td>
                        <td>{{ $row->tujuan }}</td>

                        {{-- ✅ TAMPILKAN GAMBAR --}}
                        <td>
                            @if($row->gambar)
                                <img src="{{ asset('storage/barang_keluar/' . $row->gambar) }}"
                                     class="img-thumbnail"
                                     style="width:60px; height:auto; cursor:pointer"
                                     onclick="window.open('{{ asset('storage/barang_keluar/' . $row->gambar) }}','_blank')">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $row->user->name }}</td>

                        <td>
                            <form action="{{ route('barang-keluar.destroy',$row->id) }}" method="POST"
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


{{-- ============================
    MODAL TAMBAH DATA
============================ --}}
<div class="modal fade" id="modalTambahKeluar" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('barang-keluar.store') }}" enctype="multipart/form-data" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Keluar</h5>
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
                    <label>Tujuan</label>
                    <input type="text" name="tujuan" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="form-control" required>
                </div>

                {{-- ✅ input gambar --}}
                <div class="mb-3">
                    <label>Foto / Gambar (opsional)</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
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
$(function(){
    $('#keluar').DataTable({
        scrollX:true,
        autoWidth:false
    });
});
</script>

@endsection
