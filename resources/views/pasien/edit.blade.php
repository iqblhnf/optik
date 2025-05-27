@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Edit Anamnesa</h3>
        </div>

        <form action="{{ route('anamnesa.update', $anamnesa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select">
                        @foreach ($pasien as $p)
                        <option value="{{ $p->id }}" {{ old('id_pasien', $anamnesa->id_pasien) == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @foreach (['jauh', 'dekat'] as $field)
                <div class="mb-3">
                    <label class="form-label">{{ ucfirst($field) }}</label>
                    <select name="{{ $field }}" class="form-select">
                        @foreach (['Buram', 'Berbayang', 'Jelas'] as $option)
                        <option value="{{ $option }}" {{ old($field, $anamnesa->$field) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                @endforeach

                <div class="mb-3">
                    <label class="form-label">Genetik</label>
                    <select name="gen" class="form-select">
                        <option value="Pengguna Kacamata" {{ old('gen', $anamnesa->gen) == 'Pengguna Kacamata' ? 'selected' : '' }}>Pengguna Kacamata</option>
                        <option value="Tidak" {{ old('gen', $anamnesa->gen) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Riwayat</label>
                    <select name="riwayat" class="form-select">
                        @foreach (['Hipertensi', 'Diabetes', 'Vertigo'] as $r)
                        <option value="{{ $r }}" {{ old('riwayat', $anamnesa->riwayat) == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lainnya</label>
                    <textarea name="lainnya" class="form-control">{{ old('lainnya', $anamnesa->lainnya) }}</textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('anamnesa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Form Edit Pasien</h3>
        </div>

        <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $pasien->nama) }}">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="usia" class="form-label">Usia</label>
                    <input type="text" name="usia" class="form-control @error('usia') is-invalid @enderror"
                        value="{{ old('usia', $pasien->usia) }}">
                    @error('usia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror"
                        value="{{ old('pekerjaan', $pasien->pekerjaan) }}">
                    @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                        value="{{ old('alamat', $pasien->alamat) }}">
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                        value="{{ old('no_telp', $pasien->no_telp) }}">
                    @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection