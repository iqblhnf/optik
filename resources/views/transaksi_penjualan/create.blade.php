@extends('layouts.app')
@section('title', 'Tambah Transaksi Penjualan')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Form Transaksi Penjualan</h3>
            <a href="{{ route('transaksi-penjualan.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form id="formTransaksi" action="{{ route('transaksi-penjualan.store') }}" method="POST">
            @csrf
            <div class="card-body">

                {{-- Pilih Pemeriksaan --}}
                <div class="mb-3">
                    <label for="id_pemeriksaan" class="form-label">Pilih Pemeriksaan</label>
                    <select name="id_pemeriksaan" id="id_pemeriksaan" class="form-select select2" required>
                        <option value="">-- Pilih Pemeriksaan --</option>
                        @foreach($pemeriksaan as $p)
                        <option value="{{ $p->id }}" data-pasien="{{ $p->anamnesa->pasien->id }}">
                            #{{ $p->id }} - {{ $p->anamnesa->pasien->nama }} ( {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y H:i')}} )
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pasien --}}
                <div class="mb-3">
                    <label for="id_pasien" class="form-label">Pasien</label>
                    <input type="text" id="nama_pasien" class="form-control" readonly>
                    <input type="hidden" name="id_pasien" id="id_pasien">
                </div>

                <hr>

                {{-- Tambah Item Barang/Jasa --}}
                <h5 class="fw-bold mb-3">Item Penjualan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="tableItems">
                        <thead class="table-light">
                            <tr>
                                <th style="width:25%">Nama Barang / Jasa</th>
                                <th style="width:10%">Tipe</th>
                                <th style="width:10%">Jumlah</th>
                                <th style="width:15%">Harga (Rp)</th>
                                <th style="width:15%">Subtotal</th>
                                <th style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-sm btn-primary" id="btnAddItem">
                    <i class="bi bi-plus-circle"></i> Tambah Item
                </button>

                <hr>

                {{-- Total --}}
                <div class="row justify-content-end mt-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Total (Rp)</label>
                        <input type="text" id="total_display" class="form-control fw-bold text-end" readonly value="0">
                        <input type="hidden" name="total" id="total">
                    </div>
                </div>


                {{-- Catatan --}}
                <div class="mt-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2"></textarea>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- TEMPLATE ROW ITEM --}}
<template id="rowItemTemplate">
<tr>
    <td>
        <input type="text" name="items[][nama_item]" class="form-control namaItem mb-1" placeholder="Nama barang / jasa" required>
        <select class="form-select itemSelect">
            <option value="">-- Pilih Barang dari Stok --</option>
            @foreach($barangs as $b)
            <option value="{{ $b->id }}" data-nama="{{ $b->nama_barang }}" data-harga="{{ $b->harga_jual }}">
                {{ $b->nama_barang }} (Rp {{ number_format($b->harga_jual,0,',','.') }})
            </option>
            @endforeach
        </select>
        <input type="hidden" name="items[][barang_id]" class="barangId">
    </td>
    <td>
        <select class="form-select tipeSelect" name="items[][tipe]">
            <option value="barang" selected>Barang</option>
            <option value="jasa">Jasa</option>
        </select>
    </td>
    <td><input type="number" name="items[][jumlah]" class="form-control jumlahInput" min="1" value="1"></td>
    <td><input type="number" name="items[][harga]" class="form-control hargaInput" min="0"></td>
    <td><input type="number" name="items[][subtotal]" class="form-control subtotalInput" readonly></td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-danger btnRemove"><i class="bi bi-trash"></i></button>
    </td>
</tr>
</template>

{{-- SCRIPT --}}
<script>
$(document).ready(function() {
    let itemIndex = 0;

    // isi otomatis pasien saat pilih pemeriksaan
    $('#id_pemeriksaan').on('change', function() {
        let pasienId = $(this).find(':selected').data('pasien');
        let pasienNama = $(this).find(':selected').text().split('-')[1]?.trim();
        $('#id_pasien').val(pasienId);
        $('#nama_pasien').val(pasienNama);
    });

    // tambah item baru
    $('#btnAddItem').on('click', function() {
        let row = $($('#rowItemTemplate').html());
        row.find('input, select').each(function(){
            let name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace('[]', '[' + itemIndex + ']'));
            }
        });
        itemIndex++;
        $('#tableItems tbody').append(row);
    });

    // hapus baris
    $(document).on('click', '.btnRemove', function() {
        $(this).closest('tr').remove();
        hitungTotal();
    });

    // saat ubah jumlah/harga
    $(document).on('input', '.jumlahInput, .hargaInput', function() {
        let row = $(this).closest('tr');
        let jumlah = parseFloat(row.find('.jumlahInput').val()) || 0;
        let harga = parseFloat(row.find('.hargaInput').val()) || 0;
        row.find('.subtotalInput').val(jumlah * harga);
        hitungTotal();
    });

    // pilih barang dari stok
    $(document).on('change', '.itemSelect', function() {
        let opt = $(this).find(':selected');
        let row = $(this).closest('tr');
        let harga = parseFloat(opt.data('harga')) || 0;
        row.find('.barangId').val(opt.val());
        row.find('.namaItem').val(opt.data('nama'));
        row.find('.hargaInput').val(harga);
        row.find('.tipeSelect').val('barang');
        row.find('.subtotalInput').val(harga);
        hitungTotal();
    });

    // ubah tipe jadi jasa (kosongkan select barang)
    $(document).on('change', '.tipeSelect', function() {
        let row = $(this).closest('tr');
        if ($(this).val() === 'jasa') {
            row.find('.itemSelect').val('');
            row.find('.barangId').val('');
        }
    });

    // hitung total semua subtotal
    function hitungTotal() {
        let total = 0;
        $('.subtotalInput').each(function() {
            total += parseFloat($(this).val()) || 0;
        });

        // tampilkan format ribuan di input tampil
        $('#total_display').val(total.toLocaleString('id-ID'));

        // kirim nilai mentah ke server (tanpa titik)
        $('#total').val(total);
    }

});
</script>
@endsection
