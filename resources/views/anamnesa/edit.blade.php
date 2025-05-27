@extends('layouts.app')

@section('title', 'Edit Anamnesa')

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
</div>
@endsection