@extends('layouts.app')

@section('title', 'Tambah Pasien')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Pasien</h3>
        </div>

        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="usia" class="form-label">Usia</label>
                    <input type="text" name="usia" class="form-control @error('usia') is-invalid @enderror" value="{{ old('usia') }}">
                    @error('usia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan') }}">
                    @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}">
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}">
                    @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            {{-- ✅ ANAMNESA --}}
    <hr class="mt-4">
    <h5 class="fw-bold">🩺 ANAMNESA</h5>
{{-- ✅ CARD ANAMNESA --}}
<div class="card card-info card-outline mt-4">
    <div class="card-header">
        <h5 class="card-title fw-bold"><i class="bi bi-clipboard-pulse"></i> Anamnesa Pasien</h5>
    </div>

    <div class="card-body">

        {{-- 🔹 Row 1 : Jarak Jauh / Jarak Dekat / Genetik --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jarak Jauh (👁️ Jauh)</label>
                <select name="jauh" class="form-select select2 @error('jauh') is-invalid @enderror"
                        data-placeholder="Pilih item">
                    <option value=""></option>
                    @foreach($jauhOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
                @error('jauh') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Jarak Dekat (👁️ Dekat)</label>
                <select name="dekat" class="form-select select2 @error('dekat') is-invalid @enderror"
                        data-placeholder="Pilih item">
                    <option value=""></option>
                    @foreach($dekatOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
                @error('dekat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Genetik (Riwayat Mata Keluarga)</label>
                <select name="gen" class="form-select select2 @error('gen') is-invalid @enderror"
                        data-placeholder="Pilih item">
                    <option value=""></option>
                    @foreach($genetikOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
                @error('gen') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- 🔹 Row 2: Multiselect Riwayat Penyakit --}}
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Riwayat Penyakit (bisa pilih lebih dari satu)</label>

                <select name="riwayat[]" class="form-select select2 @error('riwayat') is-invalid @enderror"
                        multiple data-placeholder="-- pilih riwayat --">
                    
                    {{-- ✅ Tambahkan opsi TIDAK ADA --}}

                    @foreach($penyakitOptions as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>

                @error('riwayat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- 🔹 Row 3: Keterangan --}}
        <div class="mb-3">
            <label class="form-label">Keterangan Tambahan</label>
            <textarea name="lainnya" class="form-control" rows="3">{{ old('lainnya') }}</textarea>
        </div>

    </div>
</div>




            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
