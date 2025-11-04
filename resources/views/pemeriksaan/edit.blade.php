@extends('layouts.app')

@section('title', 'Edit Pemeriksaan')

@section('content')
<div class="container-fluid">
    <form action="{{ route('pemeriksaan.update', $pemeriksaan->id) }}" method="POST">
        @csrf @method('PUT')

        {{-- ================= PASIEN ================= --}}
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title">Data Pasien</h3>
            </div>
            <div class="card-body row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select select2" disabled>
                        <option value="{{ $anamnesa->id_pasien }}">
                            {{ $anamnesa->pasien->nama }}
                        </option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="id_anamnesa" value="{{ $anamnesa->id }}">

            {{-- ================= ANAMNESA VIEW ONLY ================= --}}
            <div class="card card-info card-outline mt-3">
                <div class="card-header">
                    <h5 class="card-title fw-bold"><i class="bi bi-clipboard-pulse"></i> Anamnesa Pasien</h5>
                </div>

                <div class="card-body">
                    <div class="p-3 border rounded bg-light">
                        <table class="table table-bordered">
                            <tr><th>Jarak Jauh</th><td>{{ $anamnesa->jauh }}</td></tr>
                            <tr><th>Jarak Dekat</th><td>{{ $anamnesa->dekat }}</td></tr>
                            <tr><th>Genetik</th><td>{{ $anamnesa->gen }}</td></tr>
                            <tr><th>Riwayat Penyakit</th><td>{{ $anamnesa->riwayat }}</td></tr>
                            <tr><th>Keterangan Tambahan</th><td>{{ $anamnesa->lainnya }}</td></tr>
                        </table>
                    </div>

                    {{-- hidden untuk kirim ke update --}}
                    <input type="hidden" name="jauh"    value="{{ $anamnesa->jauh }}">
                    <input type="hidden" name="dekat"   value="{{ $anamnesa->dekat }}">
                    <input type="hidden" name="gen"     value="{{ $anamnesa->gen }}">
                    <input type="hidden" name="riwayat" value="{{ $anamnesa->riwayat }}">
                    <input type="hidden" name="lainnya" value="{{ $anamnesa->lainnya }}">
                </div>
            </div>
        </div>

        
        {{-- ================= PEMERIKSAAN PETUGAS ================= --}}
        <div class="alert alert-dark fw-bold mt-4">PEMERIKSAAN PETUGAS / MANUAL</div>

        <div class="row">

            {{-- OD --}}
            <div class="col-md-6">
                <div class="card border-dark shadow-sm mb-3">
                    <div class="card-header bg-dark">
                        <h5 class="mb-0 text-white">OD (Mata Kanan)</h5>
                    </div>

                    <div class="card-body">
                        {{-- DISTANCE --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="fw-semibold"><i class="ti ti-eye"></i> DISTANCE (Jauh)</h6>

                            <div class="row g-3">
                                @foreach (['sph','cyl','axis','prisma','base'] as $f)
                                <div class="col-md-4">
                                    <label class="form-label">{{ strtoupper($f) }}</label>

                                    @if ($f === 'axis')
                                        <div class="input-group">
                                            <input type="text" name="pt_od_{{ $f }}" class="form-control"
                                                value="{{ old('pt_od_'.$f, $pemeriksaan->{'pt_od_'.$f}) }}">
                                            <span class="input-group-text">°</span>
                                        </div>
                                    @else
                                        <input type="text" name="pt_od_{{ $f }}" class="form-control"
                                            value="{{ old('pt_od_'.$f, $pemeriksaan->{'pt_od_'.$f}) }}">
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="pt_od_add" class="form-control col-md-4"
                                value="{{ old('pt_od_add', $pemeriksaan->pt_od_add) }}">
                        </div>
                    </div>
                </div>
            </div>


            {{-- OS --}}
            <div class="col-md-6">
                <div class="card border-secondary shadow-sm mb-3">
                    <div class="card-header bg-secondary">
                        <h5 class="mb-0 text-white">OS (Mata Kiri)</h5>
                    </div>

                    <div class="card-body">
                        {{-- DISTANCE --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="fw-semibold"><i class="ti ti-eye"></i> DISTANCE (Jauh)</h6>

                            <div class="row g-3">
                                @foreach (['sph','cyl','axis','prisma','base'] as $f)
                                <div class="col-md-4">
                                    <label class="form-label">{{ strtoupper($f) }}</label>

                                    @if ($f === 'axis')
                                        <div class="input-group">
                                            <input type="text" name="pt_os_{{ $f }}" class="form-control"
                                                value="{{ old('pt_os_'.$f, $pemeriksaan->{'pt_os_'.$f}) }}">
                                            <span class="input-group-text">°</span>
                                        </div>
                                    @else
                                        <input type="text" name="pt_os_{{ $f }}" class="form-control"
                                            value="{{ old('pt_os_'.$f, $pemeriksaan->{'pt_os_'.$f}) }}">
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="pt_os_add" class="form-control col-md-4"
                                value="{{ old('pt_os_add', $pemeriksaan->pt_os_add) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- ================= PEMERIKSAAN ALAT ================= --}}
        <div class="alert alert-success fw-bold">PEMERIKSAAN ALAT (AUTO REFRACTOR)</div>

        <div class="row">
            {{-- OD --}}
            <div class="col-md-6">
                <div class="card border-success shadow-sm mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">OD (Mata Kanan)</h5>
                    </div>
                    <div class="card-body">

                        {{-- DISTANCE --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-success fw-semibold"><i class="ti ti-eye"></i> DISTANCE (Jauh)</h6>

                            <div class="row g-3">
                                @foreach (['sph','cyl','axis','prisma','base'] as $f)
                                <div class="col-md-4">
                                    <label class="form-label">{{ strtoupper($f) }}</label>

                                    @if ($f === 'axis')
                                        <div class="input-group">
                                            <input type="text" name="od_{{ $f }}" class="form-control"
                                                value="{{ old('od_'.$f, $pemeriksaan->{'od_'.$f}) }}">
                                            <span class="input-group-text">°</span>
                                        </div>
                                    @else
                                        <input type="text" name="od_{{ $f }}" class="form-control"
                                            value="{{ old('od_'.$f, $pemeriksaan->{'od_'.$f}) }}">
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-success fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="od_add" class="form-control col-md-4"
                                value="{{ old('od_add', $pemeriksaan->od_add) }}">
                        </div>

                    </div>
                </div>
            </div>


            {{-- OS --}}
            <div class="col-md-6">
                <div class="card border-warning shadow-sm mb-3">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0 text-dark">OS (Mata Kiri)</h5>
                    </div>

                    <div class="card-body">
                        {{-- DISTANCE --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-warning fw-semibold"><i class="ti ti-eye"></i> DISTANCE (Jauh)</h6>

                            <div class="row g-3">
                                @foreach (['sph','cyl','axis','prisma','base'] as $f)
                                <div class="col-md-4">
                                    <label class="form-label">{{ strtoupper($f) }}</label>

                                    @if ($f === 'axis')
                                        <div class="input-group">
                                            <input type="text" name="os_{{ $f }}" class="form-control"
                                                value="{{ old('os_'.$f, $pemeriksaan->{'os_'.$f}) }}">
                                            <span class="input-group-text">°</span>
                                        </div>
                                    @else
                                        <input type="text" name="os_{{ $f }}" class="form-control"
                                            value="{{ old('os_'.$f, $pemeriksaan->{'os_'.$f}) }}">
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-warning fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="os_add" class="form-control col-md-4"
                                value="{{ old('os_add', $pemeriksaan->os_add) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- ================= LAINNYA ================= --}}
        <div class="card card-secondary card-outline mt-3">
            <div class="card-header">
                <h3 class="card-title">Lainnya</h3>
            </div>
            <div class="card-body row">
                <div class="mb-3 col-md-6">
                    <label>BINOCULER PD</label>
                    <input type="text" name="binoculer_pd" class="form-control"
                        value="{{ old('binoculer_pd', $pemeriksaan->binoculer_pd) }}">
                </div>

                <div class="mb-3 col-md-6">
                    <label>Waktu Mulai</label>
                    <input type="datetime-local" name="waktu_mulai" class="form-control"
                        value="{{ old('waktu_mulai', $pemeriksaan->waktu_mulai->format('Y-m-d\TH:i')) }}" disabled>
                </div>

                <div class="mb-3 col-md-12">
                    <label>Keterangan</label>
                    <textarea name="keterangan_kacamata_lama" class="form-control">{{ old('keterangan_kacamata_lama', $pemeriksaan->keterangan_kacamata_lama) }}</textarea>
                </div>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-success"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>
        </div>

    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    function formatWithSign(input) {
        input.addEventListener("blur", function () {
            let val = this.value.trim();

            if (val === "") return;

            // deteksi apakah ada tanda + atau -
            const sign = val.startsWith("+") ? "+" :
                         val.startsWith("-") ? "-" : "";

            // hilangkan tanda dulu untuk proses angka
            val = val.replace(",", ".").replace(/^[+-]/, "");

            // cek apakah angka valid
            if (/^\d*\.?\d+$/.test(val)) {
                let formatted = parseFloat(val).toFixed(2);

                // jika awalnya ada tanda + atau -, gabungkan kembali
                if (sign) {
                    this.value = sign + formatted;
                } else {
                    this.value = formatted;
                }
            }
        });
    }

    document.querySelectorAll("input[name^='od_'], input[name^='os_'], input[name^='pt_od_'], input[name^='pt_os_']")
        .forEach(function (input) {

            // ❌ abaikan _axis (derajat)
            if (input.name.includes("_axis")) return;

            formatWithSign(input);
        });
});
</script>


@endsection
