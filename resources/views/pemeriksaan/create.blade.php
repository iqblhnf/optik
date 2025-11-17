@extends('layouts.app')

@section('title', 'Tambah Pemeriksaan')

@section('content')
<div class="container-fluid">
    <form action="{{ route('pemeriksaan.store') }}" method="POST">
        @csrf

        {{-- ================= PASIEN ================= --}}
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title">Data Pasien</h3>
            </div>
            <div class="card-body row">
                <div class="mb-3 col-md-4">
                    <label for="id_pasien" class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select select2 @error('id_pasien') is-invalid @enderror">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pasien as $p)
                        <option value="{{ $p->id }}" {{ old('id_pasien') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }} ({{ $p->no_rm }})
                        </option>
                        @endforeach
                    </select>
                    @error('id_pasien')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="id_anamnesa">


            {{-- ================= ANAMNESA VIEW ONLY ================= --}}
            <div class="card card-info card-outline mt-3">
                <div class="card-header">
                    <h5 class="card-title fw-bold"><i class="bi bi-clipboard-pulse"></i> Anamnesa Pasien</h5>
                </div>

                <div class="card-body">
                    <div id="anamnesa-view" class="p-3 border rounded bg-light">
                        <p class="text-muted m-0">Silahkan pilih pasien terlebih dahulu.</p>
                    </div>

                    {{-- hidden input untuk dikirim ke pemeriksaan --}}
                    <input type="hidden" name="jauh">
                    <input type="hidden" name="dekat">
                    <input type="hidden" name="gen">
                    <input type="hidden" name="riwayat">
                    <input type="hidden" name="lainnya">
                </div>
            </div>
        </div>

        
        {{-- ========================================================= --}}
        {{-- ================= PEMERIKSAAN PETUGAS ================== --}}
        {{-- ========================================================= --}}

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
                                @foreach (['sph','cyl','axis','prisma','base'] as $field)
                                    <div class="col-md-4">
                                        <label class="form-label">{{ strtoupper($field) }}</label>
                                        @if ($field === 'axis')
                                            <div class="input-group">
                                                <input type="text" name="pt_od_{{ $field }}" class="form-control">
                                                <span class="input-group-text">°</span>
                                            </div>
                                        @else
                                            <input type="text" name="pt_od_{{ $field }}" class="form-control">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="pt_od_add" class="form-control col-md-4">
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
                                @foreach (['sph','cyl','axis','prisma','base'] as $field)
                                    <div class="col-md-4">
                                        <label class="form-label">{{ strtoupper($field) }}</label>
                                        @if ($field === 'axis')
                                            <div class="input-group">
                                                <input type="text" name="pt_os_{{ $field }}" class="form-control">
                                                <span class="input-group-text">°</span>
                                            </div>
                                        @else
                                            <input type="text" name="pt_os_{{ $field }}" class="form-control">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="pt_os_add" class="form-control col-md-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- ==================== PEMERIKSAAN ALAT =================== --}}
        {{-- ========================================================= --}}

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
                                @foreach (['sph','cyl','axis','prisma','base'] as $field)
                                    <div class="col-md-4">
                                        <label class="form-label">{{ strtoupper($field) }}</label>
                                        @if ($field === 'axis')
                                            <div class="input-group">
                                                <input type="text" name="od_{{ $field }}" class="form-control">
                                                <span class="input-group-text">°</span>
                                            </div>
                                        @else
                                            <input type="text" name="od_{{ $field }}" class="form-control">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-success fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="od_add" class="form-control col-md-4">
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
                                @foreach (['sph','cyl','axis','prisma','base'] as $field)
                                    <div class="col-md-4">
                                        <label class="form-label">{{ strtoupper($field) }}</label>
                                        @if ($field === 'axis')
                                            <div class="input-group">
                                                <input type="text" name="os_{{ $field }}" class="form-control">
                                                <span class="input-group-text">°</span>
                                            </div>
                                        @else
                                            <input type="text" name="os_{{ $field }}" class="form-control">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-warning fw-semibold"><i class="ti ti-eye-plus"></i> NEAR (Dekat)</h6>
                            <input type="text" name="os_add" class="form-control col-md-4">
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
                    <input type="text" name="binoculer_pd" class="form-control">
                </div>

                <div class="mb-3 col-md-6">
                    <label>Waktu Mulai</label>
                    <div class="input-group">
                        <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="form-control">
                        <button class="btn btn-outline-secondary" type="button" id="btn-waktu">
                            <i class="bi bi-clock-history"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3 col-md-12">
                    <label>Keterangan</label>
                    <textarea name="keterangan_kacamata_lama" class="form-control"></textarea>
                </div>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>
        </div>

    </form>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const selectPasien = document.querySelector("select[name='id_pasien']");
    const viewDiv = document.getElementById("anamnesa-view");

    $(selectPasien).on("change", function () {
        let id = this.value;
        if (!id) return;

        fetch("{{ url('/api/anamnesa') }}/" + id)
            .then(res => res.json())
            .then(data => {
                // 🔹 Parsing fungsi bantu
                const parseToText = (input) => {
                    if (!input) return '-';
                    if (typeof input === "string" && input.startsWith("[")) {
                        try {
                            const arr = JSON.parse(input);
                            return Array.isArray(arr) ? arr.join(", ") : input;
                        } catch {
                            return input;
                        }
                    }
                    if (Array.isArray(input)) {
                        return input.join(", ");
                    }
                    return input;
                };

                // 🔹 Format tiap bagian anamnesa
                let jauhFormatted = parseToText(data.jauh);
                let dekatFormatted = parseToText(data.dekat);
                let riwayatFormatted = parseToText(data.riwayat);

                // 🔹 Ambil biodata pasien dari respons
                const pasien = data.pasien || {};

                // 🔹 Tampilkan di div
                viewDiv.innerHTML = `
                    <div class="mb-3">
                        <h5 class="fw-bold"><i class="bi bi-person-vcard"></i> Biodata Pasien</h5>
                        <table class="table table-bordered table-sm">
                            <tr><th width="180">No. Rekam Medis</th><td>${pasien.no_rm ?? '-'}</td></tr>
                            <tr><th>Nama Lengkap</th><td>${pasien.nama ?? '-'}</td></tr>
                            <tr><th>Usia</th><td>${pasien.usia ? pasien.usia + ' tahun' : '-'}</td></tr>
                            <tr><th>Jenis Kelamin</th><td>${pasien.jenis_kelamin ?? '-'}</td></tr>
                            <tr><th>Pekerjaan</th><td>${pasien.pekerjaan ?? '-'}</td></tr>
                            <tr><th>Alamat</th><td>${pasien.alamat ?? '-'}</td></tr>
                            <tr><th>No. Telepon</th><td>${pasien.telepon ?? '-'}</td></tr>
                        </table>
                    </div>

                    <h5 class="fw-bold"><i class="bi bi-clipboard2-pulse"></i> Anamnesa Pasien</h5>
                    <table class="table table-bordered">
                        <tr><th>Jarak Jauh</th><td>${jauhFormatted}</td></tr>
                        <tr><th>Jarak Dekat</th><td>${dekatFormatted}</td></tr>
                        <tr><th>Genetik</th><td>${data.gen}</td></tr>
                        <tr><th>Riwayat Penyakit</th><td>${riwayatFormatted}</td></tr>
                        <tr><th>Keterangan Tambahan</th><td>${data.lainnya ?? '-'}</td></tr>
                    </table>
                `;

                // 🔹 Tambahkan tabel kacamata lama jika ada
                if (data.kacamata_lama) {
                    let k = data.kacamata_lama;
                    viewDiv.innerHTML += `
                        <table class="table table-bordered mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2" class="text-center align-middle"> </th>
                                    <th colspan="6" class="text-center">PEMERIKSAAN KACAMATA LAMA</th>
                                </tr>
                                <tr class="text-center">
                                    <th>SPH</th><th>CYL</th><th>AXIS</th><th>PRISMA</th><th>BASE</th><th>ADD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <th>OD</th>
                                    <td>${k.od_sph ?? '-'}</td><td>${k.od_cyl ?? '-'}</td><td>${k.od_axis ?? '-'}</td>
                                    <td>${k.od_prisma ?? '-'}</td><td>${k.od_base ?? '-'}</td><td>${k.od_add ?? '-'}</td>
                                </tr>
                                <tr class="text-center">
                                    <th>OS</th>
                                    <td>${k.os_sph ?? '-'}</td><td>${k.os_cyl ?? '-'}</td><td>${k.os_axis ?? '-'}</td>
                                    <td>${k.os_prisma ?? '-'}</td><td>${k.os_base ?? '-'}</td><td>${k.os_add ?? '-'}</td>
                                </tr>
                            </tbody>
                        </table>
                    `;
                }



                // 🔹 Isi kembali input (jika ada form edit)
                document.querySelector("input[name='gen']").value = data.gen ?? '';
                document.querySelector("textarea[name='lainnya']").value = data.lainnya ?? '';

                // Jika pakai select2 multi
                if ($('.select2').length) {
                    const setSelectValues = (name, val) => {
                        let parsed = [];
                        if (typeof val === "string" && val.startsWith("[")) {
                            try { parsed = JSON.parse(val); } catch {}
                        } else if (Array.isArray(val)) {
                            parsed = val;
                        } else if (val) {
                            parsed = [val];
                        }
                        $(`select[name='${name}[]']`).val(parsed).trigger('change');
                    };

                    setSelectValues('jauh', data.jauh);
                    setSelectValues('dekat', data.dekat);
                    setSelectValues('riwayat', data.riwayat);
                }
            })
        });
});
</script>
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
