@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Form Edit Pasien</h3>
        </div>

        <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="card-body">
                {{-- DATA PASIEN --}}

                <div class="mb-3">
                    <label class="form-label">No. Rekam Medis</label>
                    <input type="number" name="no_rm" class="form-control"
                        value="{{ old('no_rm', $pasien->no_rm) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                        value="{{ old('nama', $pasien->nama) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Usia</label>
                    <input type="text" name="usia" class="form-control"
                        value="{{ old('usia', $pasien->usia) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $pasien->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control"
                        value="{{ old('pekerjaan', $pasien->pekerjaan) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control"
                        value="{{ old('alamat', $pasien->alamat) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control"
                        value="{{ old('no_telp', $pasien->no_telp) }}">
                </div>

                <div class="mb-4">
    <hr>
    <h5 class="fw-bold">👁️ Pemeriksaan Mata</h5>

    <div class="table-responsive mt-3">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th> </th>
                    <th>SPH</th>
                    <th>CYL</th>
                    <th>AXIS</th>
                    <th>PRISMA</th>
                    <th>BASE</th>
                    <th>ADD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>OD (Kanan)</th>
                    <td><input type="text" name="od_sph" class="form-control" value="{{ old('od_sph', $pasien->od_sph) }}"></td>
                    <td><input type="text" name="od_cyl" class="form-control" value="{{ old('od_cyl', $pasien->od_cyl) }}"></td>
                    <td><input type="text" name="od_axis" class="form-control" value="{{ old('od_axis', $pasien->od_axis) }}"></td>
                    <td><input type="text" name="od_prisma" class="form-control" value="{{ old('od_prisma', $pasien->od_prisma) }}"></td>
                    <td><input type="text" name="od_base" class="form-control" value="{{ old('od_base', $pasien->od_base) }}"></td>
                    <td><input type="text" name="od_add" class="form-control" value="{{ old('od_add', $pasien->od_add) }}"></td>
                </tr>
                <tr>
                    <th>OS (Kiri)</th>
                    <td><input type="text" name="os_sph" class="form-control" value="{{ old('os_sph', $pasien->os_sph) }}"></td>
                    <td><input type="text" name="os_cyl" class="form-control" value="{{ old('os_cyl', $pasien->os_cyl) }}"></td>
                    <td><input type="text" name="os_axis" class="form-control" value="{{ old('os_axis', $pasien->os_axis) }}"></td>
                    <td><input type="text" name="os_prisma" class="form-control" value="{{ old('os_prisma', $pasien->os_prisma) }}"></td>
                    <td><input type="text" name="os_base" class="form-control" value="{{ old('os_base', $pasien->os_base) }}"></td>
                    <td><input type="text" name="os_add" class="form-control" value="{{ old('os_add', $pasien->os_add) }}"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


{{-- ================= ANAMNESA ================= --}}
<hr class="mt-4">
<h5 class="fw-bold">🩺 ANAMNESA</h5>

<div class="card card-info card-outline mt-3">
    <div class="card-header">
        <h5 class="card-title fw-bold">Anamnesa Pasien</h5>
    </div>

    <div class="card-body row">
        {{-- JAUH --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Jarak Jauh</label>
            <select name="jauh[]" multiple class="form-select select2">
                @foreach($jauhOptions as $opt)
                    <option value="{{ $opt }}" 
                        @if(in_array($opt, $selectedJauh)) selected @endif>
                        {{ $opt }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DEKAT --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Jarak Dekat</label>
            <select name="dekat[]" multiple class="form-select select2">
                @foreach($dekatOptions as $opt)
                    <option value="{{ $opt }}" 
                        @if(in_array($opt, $selectedDekat)) selected @endif>
                        {{ $opt }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- GENETIK --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Genetik</label>
            <select name="gen" class="form-select select2">
                @foreach($genetikOptions as $opt)
                    <option value="{{ $opt }}" {{ $anamnesa->gen == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>

        {{-- RIWAYAT PENYAKIT MULTI SELECT --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">Riwayat Penyakit (bisa pilih lebih dari satu)</label>
            <select name="riwayat[]" multiple class="form-select select2" data-placeholder="-- pilih riwayat --">
                @foreach($penyakitOptions as $p)
                    <option value="{{ $p }}"
                        @if(in_array($p, $selectedRiwayat)) selected @endif>
                        {{ $p }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- LAINNYA --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">Keterangan Tambahan</label>
            <textarea name="lainnya" class="form-control">{{ $anamnesa->lainnya ?? '' }}</textarea>
        </div>

    </div>
</div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

{{-- Select2 --}}
<script>
$(document).ready(function() {
    $('.select2').select2({
        tags: true,
        width: '100%'
    });
});
</script>

@endsection
