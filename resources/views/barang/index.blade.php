@extends('layouts.app')
@section('title', 'Data Barang')

@section('content')

<style>
    #formTambah { display:none; }
</style>

@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<div class="container-fluid">

    {{-- ========================================= --}}
    {{--  TOMBOL TAMBAH --}}
    {{-- ========================================= --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
       
        <button class="btn btn-primary" id="btnTambah">
            <i class="bi bi-plus-circle"></i> Tambah Barang
        </button>
    </div>

    {{-- ========================================= --}}
    {{--  FORM TAMBAH / EDIT --}}
    {{-- ========================================= --}}
    <div id="formTambah" class="card shadow-sm border-primary mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <span id="titleForm">Tambah Barang</span>
            <button class="btn btn-light btn-sm" id="btnTutupForm"><i class="bi bi-x-lg"></i></button>
        </div>

        <form id="formBarang" method="POST" action="{{ route('barang.store') }}">
            @csrf
            <div class="card-body row">

                <div class="mb-3 col-md-6">
                    <label class="form-label">Kode Barang *</label>
                    <input type="text" name="kode_barang" class="form-control" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Nama Barang *</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" id="kategoriSelect" class="form-select select2">
                        <option value="">-- Pilih Item --</option>
                        <option value="Frame">Frame</option>
                        <option value="Lensa">Lensa</option>
                        <option value="Aksesoris">Aksesoris</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" id="satuanSelect" class="form-select select2">
                        <option value="">-- Pilih Item --</option>
                        <option value="pcs">pcs</option>
                        <option value="box">box</option>
                        <option value="pack">pack</option>
                        <option value="lusin">lusin</option>
                    </select>
                </div>
            </div>

            <div class="card-footer text-end">
                <button id="btnSubmit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>

        </form>
    </div>

    {{-- ========================================= --}}
    {{--  TABEL BARANG --}}
    {{-- ========================================= --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div style="overflow-x:auto;">
                <table id="barang" class="table table-bordered table-hover align-middle nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th style="width:5%">#</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th style="width:15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangs as $index => $b)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $b->kode_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori }}</td>
                            <td>{{ $b->satuan }}</td>
                            <td>{{ $b->stok }}</td>
                            <td class="text-center">

                                {{-- 🔹 EDIT BUTTON --}}
                                <button type="button" class="btn btn-sm btn-warning btnEdit"
                                    data-id="{{ $b->id }}"
                                    data-kode="{{ $b->kode_barang }}"
                                    data-nama="{{ $b->nama_barang }}"
                                    data-kategori="{{ $b->kategori }}"
                                    data-satuan="{{ $b->satuan }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                {{-- 🔹 DELETE --}}
                                <form action="{{ route('barang.destroy',$b->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
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
</div>
@endsection


@section('scripts')
<script>
$(document).ready(function(){

    $('#barang').DataTable({scrollX:true});
    $('.select2').select2({tags:true, width:"100%"});

    $("#btnTambah").click(function(){
        resetForm();
        $("#formTambah").slideDown();
        $("#btnTambah").hide();
        $("#titleForm").text("Tambah Barang");
    });

    $("#btnTutupForm").click(function(){
        resetForm();
        $("#formTambah").slideUp();
        $("#btnTambah").show();
    });

    function resetForm() {
        $("#formBarang").attr("action", "{{ route('barang.store') }}");
        $("#formBarang input[name=_method]").remove();
        $("#btnSubmit").html('<i class="bi bi-save"></i> Simpan');
        $("#formBarang")[0].reset();
        $('#kategoriSelect, #satuanSelect').val("").trigger("change");
    }

    // ✅ CLICK EDIT
    $(".btnEdit").click(function(){
        let id   = $(this).data("id");
        let kode = $(this).data("kode");
        let nama = $(this).data("nama");
        let kategori = $(this).data("kategori");
        let satuan = $(this).data("satuan");

        $("#formTambah").slideDown();
        $("#btnTambah").hide();
        $("#titleForm").text("Edit Barang");

        $("#formBarang").attr("action", "/barang/" + id);
        $("#formBarang").append('<input type="hidden" name="_method" value="PUT">');

        $("input[name='kode_barang']").val(kode);
        $("input[name='nama_barang']").val(nama);
        $("#kategoriSelect").val(kategori).trigger("change");
        $("#satuanSelect").val(satuan).trigger("change");

        $("#btnSubmit").html('<i class="bi bi-check-circle"></i> Update');
    });

});
</script>
@endsection
