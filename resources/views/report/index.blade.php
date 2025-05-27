@extends('layouts.app')

@section('title', 'Laporan Pemeriksaan')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Laporan Pemeriksaan</h3>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="GET" class="row row-cols-lg-auto g-3 align-items-end mb-4">
                <div class="col">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ $tanggal_awal }}">
                </div>
                <div class="col">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ $tanggal_akhir }}">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    <a href="{{ route('laporan') }}" class="btn btn-secondary ms-2">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle nowrap" id="laporan">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Jenis Kelamin</th>
                            <th>Usia</th>
                            <th>OD SPH</th>
                            <th>OS SPH</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->created_at->translatedFormat('d M Y H:i') }}</td>
                            <td>{{ $item->anamnesa->pasien->nama ?? '-' }}</td>
                            <td>{{ $item->anamnesa->pasien->jenis_kelamin ?? '-' }}</td>
                            <td>{{ $item->anamnesa->pasien->usia ?? '-' }}</td>
                            <td>{{ $item->od_sph }}</td>
                            <td>{{ $item->os_sph }}</td>
                            <td>{{ $item->keterangan_kacamata_lama }}</td>
                            <td>
                                <a href="{{ route('pemeriksaan.print', $item->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                                    <i class="bi bi-printer"></i> Cetak
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

<script>
    $(function() {
        $('#laporan').DataTable({
            scrollX: true,
            autoWidth: false,
            ordering: false
        });
    });
</script>
@endsection