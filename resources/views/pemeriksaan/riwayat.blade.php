@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan')

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
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table id="riwayat" class="table table-bordered table-hover align-middle nowrap" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pasien</th>
                            <th>Tanggal Pemeriksaan</th>
                            <th>Status Kacamata Lama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->anamnesa->pasien->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y H:i') }}</td>
                            <td>{{ $item->status_kacamata_lama }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="{{ route('pemeriksaan.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{ route('pemeriksaan.print', $item->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <form action="{{ route('pemeriksaan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal Detail Pemeriksaan --}}
                        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $item->id }}">
                                            Detail Pemeriksaan - {{ $item->anamnesa->pasien->nama ?? '-' }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- === DATA ANAMNESA === --}}
                                        <div class="mb-4">
                                            <h5><strong>Data Anamnesa</strong></h5>
                                            <ul class="mb-2">
                                                <li><strong>Penglihatan Jarak Jauh:</strong> {{ $item->anamnesa->jauh ?? '-' }}</li>
                                                <li><strong>Penglihatan Jarak Dekat:</strong> {{ $item->anamnesa->dekat ?? '-' }}</li>
                                                <li><strong>Penggunaan Kacamata:</strong> {{ $item->anamnesa->gen ?? '-' }}</li>
                                                <li><strong>Riwayat Penyakit:</strong> {{ $item->anamnesa->riwayat ?? '-' }}</li>
                                                <li><strong>Lainnya:</strong> {{ $item->anamnesa->lainnya ?? '-' }}</li>
                                            </ul>
                                        </div>

                                        {{-- === PEMERIKSAAN MATA === --}}
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <h6><strong>OD (Mata Kanan)</strong></h6>
                                                <ul class="mb-3">
                                                    <li>SPH: {{ $item->od_sph }}</li>
                                                    <li>CYL: {{ $item->od_cyl }}</li>
                                                    <li>AXIS: {{ $item->od_axis }}</li>
                                                    <li>ADD: {{ $item->od_add }}</li>
                                                    <li>PRISMA: {{ $item->od_prisma }}</li>
                                                    <li>BASE: {{ $item->od_base }}</li>
                                                </ul>
                                            </div>

                                            <div class="col-md-6">
                                                <h6><strong>OS (Mata Kiri)</strong></h6>
                                                <ul class="mb-3">
                                                    <li>SPH: {{ $item->os_sph }}</li>
                                                    <li>CYL: {{ $item->os_cyl }}</li>
                                                    <li>AXIS: {{ $item->os_axis }}</li>
                                                    <li>ADD: {{ $item->os_add }}</li>
                                                    <li>PRISMA: {{ $item->os_prisma }}</li>
                                                    <li>BASE: {{ $item->os_base }}</li>
                                                </ul>
                                            </div>

                                            <div class="col-md-6">
                                                <h6><strong>Binokuler</strong></h6>
                                                <p><strong>PD:</strong> {{ $item->binoculer_pd }}</p>
                                            </div>

                                            <div class="col-md-6">
                                                <h6><strong>Status Kacamata:</strong></h6>
                                                <p>{{ $item->status_kacamata_lama }}</p>
                                                <h6><strong>Keterangan:</strong></h6>
                                                <p>{{ $item->keterangan_kacamata_lama }}</p>
                                            </div>

                                            <div class="col-12">
                                                <h6><strong>Informasi Pemeriksaan</strong></h6>
                                                <p><strong>Tanggal Pemeriksaan:</strong> {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                        @endforelse
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
        $('#riwayat').DataTable({
            scrollX: true,
            autoWidth: false
        });
    });
</script>
@endsection