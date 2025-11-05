@extends('layouts.app')

@section('title', 'Pemeriksaan')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Pemeriksaan</h3>
            <a href="{{ route('pemeriksaan.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>

        <div class="card-body">
            <table id="pemeriksaan" class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px;"></th>
                        <th>#</th>
                        <th>Pasien</th>
                        <th>Usia</th>
                        <th>JK</th>
                        <th>Alamat</th>
                        <th>Jumlah Pemeriksaan</th>
                        {{-- <th class="text-center">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                    @php $riwayatBase64 = base64_encode(json_encode($item['riwayat'])); @endphp
                    <tr data-id="{{ $item['id'] }}" data-riwayat="{{ $riwayatBase64 }}">
                        <td class="details-control text-center text-primary fw-bold" style="cursor:pointer;">▶️</td>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ $item['usia'] }}</td>
                        <td>{{ $item['jenis_kelamin'] }}</td>
                        <td>{{ $item['alamat'] }}</td>
                        <td>{{ $item['jumlah_pemeriksaan'] }}</td>
                        {{-- <td class="text-center">
                            <button class="btn btn-sm btn-info text-white view-detail" data-id="{{ $item['id'] }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail Pemeriksaan --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDetailLabel">Detail Pemeriksaan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailContent">
        <div class="text-center py-4 text-muted">
          <div class="spinner-border text-primary mb-2"></div><br>Memuat data...
        </div>
      </div>
    </div>
  </div>
</div>

<style>
tr.shown { background-color: #f8fbff !important; }
td.details-control { cursor: pointer; font-size: 18px; }
td.details-control:hover { color: #0d6efd; }
</style>

<script>
function base64ToJson(base64) {
    try { return JSON.parse(atob(base64)); }
    catch(e) { console.error("JSON error:", e); return []; }
}

function formatRiwayat(riwayat) {
    if (!riwayat.length) return '<em class="text-muted">Belum ada pemeriksaan.</em>';

    let html = `
        <div class="p-2">
        <table class="table table-sm table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                    <th>OD SPH</th>
                    <th>OS SPH</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
    `;

    riwayat.forEach(r => {
        const editUrl = `/pemeriksaan/${r.id}/edit`;
        const printUrl = `/pemeriksaan/${r.id}/print`;
        const deleteUrl = `/pemeriksaan/${r.id}`;
        html += `
            <tr>
                <td>${r.tgl ?? '-'}</td>
                <td>${r.petugas ?? '-'}</td>
                <td>${r.od_sph ?? '-'}</td>
                <td>${r.os_sph ?? '-'}</td>
                <td>${r.waktu_mulai ?? '-'}</td>
                <td>${r.waktu_selesai ?? '-'}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info text-white view-detail-row" data-id="${r.id}">
                        <i class="bi bi-eye"></i>
                    </button>
                    <a href="${printUrl}" class="btn btn-sm btn-secondary" target="_blank">
                        <i class="bi bi-printer"></i>
                    </a>
                    <a href="${editUrl}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="${deleteUrl}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        `;
    });

    html += '</tbody></table></div>';
    return html;
}


$(document).ready(function(){
    let table = $('#pemeriksaan').DataTable({
        responsive: true,
        ordering: true,
        paging: true,
        searching: true
    });

    // Expand-collapse behavior
    $('#pemeriksaan tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = table.row(tr);
        let id = tr.data('id');
        let riwayat = base64ToJson(tr.data('riwayat'));
        let icon = tr.find('td.details-control');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            icon.text('▶️');
        } else {
            row.child(formatRiwayat(riwayat)).show();
            tr.addClass('shown');
            icon.text('▼');
        }
    });

    // Modal detail (baik dari tombol luar maupun dari dalam riwayat)
    $(document).on('click', '.view-detail, .view-detail-row', function(){
        const id = $(this).data('id');
        $('#modalDetail').modal('show');
        $('#detailContent').html('<div class="text-center py-4 text-muted"><div class="spinner-border text-primary mb-2"></div><br>Memuat data...</div>');
        
        fetch(`/pemeriksaan/${id}`)
            .then(res => res.text())
            .then(html => $('#detailContent').html(html))
            .catch(() => $('#detailContent').html('<p class="text-danger">Gagal memuat data.</p>'));
    });
});
</script>
@endsection
