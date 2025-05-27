@extends('layouts.app')

@section('title', 'Tambah Anamnesa')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Tambah Anamnesa</h3>
        </div>

        <form action="{{ route('anamnesa.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="id_pasien" class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select @error('id_pasien') is-invalid @enderror">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pasien as $p)
                        <option value="{{ $p->id }}" {{ old('id_pasien') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_pasien') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                @foreach (['jauh', 'dekat'] as $field)
                <div class="mb-3">
                    <label class="form-label">{{ ucfirst($field) }}</label>
                    <select name="{{ $field }}" class="form-select @error($field) is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach (['Buram', 'Berbayang', 'Jelas'] as $option)
                        <option value="{{ $option }}" {{ old($field) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @endforeach

                <div class="mb-3">
                    <label class="form-label">Genetik</label>
                    <select name="gen" class="form-select @error('gen') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Pengguna Kacamata" {{ old('gen') == 'Pengguna Kacamata' ? 'selected' : '' }}>Pengguna Kacamata</option>
                        <option value="Tidak" {{ old('gen') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('gen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Riwayat</label>
                    <select name="riwayat" class="form-select @error('riwayat') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach (['Hipertensi', 'Diabetes', 'Vertigo'] as $r)
                        <option value="{{ $r }}" {{ old('riwayat') == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                    @error('riwayat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Lainnya</label>
                    <textarea name="lainnya" class="form-control @error('lainnya') is-invalid @enderror">{{ old('lainnya') }}</textarea>
                    @error('lainnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('anamnesa.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
