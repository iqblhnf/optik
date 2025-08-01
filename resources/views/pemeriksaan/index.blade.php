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
                <div class="mb-3">
                    <button id="collapseAll" class="btn btn-sm btn-secondary">Tutup Semua</button>
                </div>

                <table id="pemeriksaan" class="table table-striped table-bordered align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Pasien</th>
                            <th>Usia</th>
                            <th>JK</th>
                            <th>Alamat</th>
                            <th>Jumlah Pemeriksaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                        @php
                        $riwayatBase64 = base64_encode(json_encode($item['riwayat']));
                        @endphp
                        <tr
                            data-id="{{ $item['id'] }}"
                            data-riwayat="{{ $riwayatBase64 }}">
                            <td class="details-control">▶️</td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item["nama"] }}</td>
                            <td>{{ $item["usia"] }}</td>
                            <td>{{ $item["jenis_kelamin"] }}</td>
                            <td>{{ $item["alamat"] }}</td>
                            <td>{{ $item["jumlah_pemeriksaan"] }}</td>
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

<style>
    tr.shown {
        background-color: #f0f9ff !important;
    }

    td.details-control {
        cursor: pointer;
        text-align: center;
        font-weight: bold;
        color: #0d6efd;
        font-size: 18px;
        width: 40px;
    }
</style>

<script>
    function base64ToJson(base64) {
        try {
            return JSON.parse(atob(base64));
        } catch (e) {
            console.error("JSON Parse Error:", e);
            return [];
        }
    }

    function formatRiwayat(riwayat) {
        let html = '<div style="overflow-x:auto"><table class="table table-sm table-bordered mb-0">';
        html += `
        <thead class="table-light">
            <tr>
                <th>Tanggal Pemeriksaan</th><th>Petugas</th>
                <th>OD SPH</th><th>OD CYL</th><th>OD AXIS</th><th>OD ADD</th>
                <th>OD Prisma</th><th>OD Base</th>
                <th>OS SPH</th><th>OS CYL</th><th>OS AXIS</th><th>OS ADD</th>
                <th>OS Prisma</th><th>OS Base</th>
                <th>Bin PD</th>
                <th>Status Kacamata Lama</th>
                <th>Keterangan Kacamata Lama</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead><tbody>
    `;

        riwayat.forEach(r => {
            let editUrl = `/pemeriksaan/${r.id}/edit`;
            let printUrl = `/pemeriksaan/${r.id}/print`;
            let deleteUrl = `/pemeriksaan/${r.id}/delete`; // pastikan route delete pakai form/JS

            html += `
            <tr>
                <td>${r.tgl ?? '-'}</td>
                <td>${r.petugas ?? '-'}</td>
                <td>${r.od_sph ?? '-'}</td>
                <td>${r.od_cyl ?? '-'}</td>
                <td>${r.od_axis ?? '-'}</td>
                <td>${r.od_add ?? '-'}</td>
                <td>${r.od_prisma ?? '-'}</td>
                <td>${r.od_base ?? '-'}</td>
                <td>${r.os_sph ?? '-'}</td>
                <td>${r.os_cyl ?? '-'}</td>
                <td>${r.os_axis ?? '-'}</td>
                <td>${r.os_add ?? '-'}</td>
                <td>${r.os_prisma ?? '-'}</td>
                <td>${r.os_base ?? '-'}</td>
                <td>${r.binoculer_pd ?? '-'}</td>
                <td>${r.status_kacamata_lama ?? '-'}</td>
                <td>${r.keterangan_kacamata_lama ?? '-'}</td>
                <td>${r.waktu_mulai ?? '-'}</td>
                <td>${r.waktu_selesai ?? '-'}</td>
                <td class="text-center">
                    <a href="${editUrl}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="${printUrl}" class="btn btn-sm btn-secondary" target="_blank"><i class="bi bi-printer"></i></a>
                    <a href="${deleteUrl}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
        `;
        });

        html += '</tbody></table></div>';
        return html;
    }

    $(document).ready(function() {
        let table = $('#pemeriksaan').DataTable({
            responsive: true,
            ordering: true,
            paging: true,
            searching: true
        });

        let expandedRows = new Set();

        function toggleRow(tr, row) {
            let td = tr.find('td.details-control');
            let isShown = row.child.isShown();
            let id = tr.data('id');

            if (isShown) {
                $('div.slider', row.child()).slideUp(300, function() {
                    row.child.hide();
                    tr.removeClass('shown');
                    td.text('▶️');
                    expandedRows.delete(id);
                });
            } else {
                let riwayat = base64ToJson(tr.attr('data-riwayat'));
                row.child('<div class="slider">' + formatRiwayat(riwayat) + '</div>', 'p-0').show();
                tr.addClass('shown');
                td.text('▼');
                $('div.slider', row.child()).slideDown(300);
                expandedRows.add(id);
            }
        }

        $('#pemeriksaan tbody').on('click', 'td.details-control', function() {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            toggleRow(tr, row);
        });

        table.on('draw', function() {
            $('#pemeriksaan tbody tr').each(function() {
                let tr = $(this);
                let id = tr.data('id');
                if (expandedRows.has(id)) {
                    toggleRow(tr, table.row(tr));
                }
            });
        });

        $('#collapseAll').on('click', function() {
            $('#pemeriksaan tbody tr.shown').each(function() {
                toggleRow($(this), table.row(this));
            });
        });
    });
</script>

@endsection