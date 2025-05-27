@extends('layouts.app')

@section('title', 'Edit Pemeriksaan')

@section('content')
<div class="container-fluid">
    <form action="{{ route('pemeriksaan.update', $pemeriksaan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title">Anamnesa</h3>
            </div>
            <div class="card-body row">
                <div class="mb-3 col-md-4">
                    <label for="id_pasien" class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select select2">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pasien as $p)
                        <option value="{{ $p->id }}" {{ old('id_pasien', $pemeriksaan->anamnesa->id_pasien) == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @foreach (['jauh', 'dekat'] as $field)
                <div class="mb-3 col-md-4">
                    <label class="form-label">{{ ucfirst($field) }}</label>
                    <select name="{{ $field }}" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach (['Buram', 'Berbayang', 'Jelas'] as $option)
                        <option value="{{ $option }}" {{ old($field, $pemeriksaan->anamnesa->$field) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                @endforeach

                <div class="mb-3 col-md-4">
                    <label class="form-label">Genetik</label>
                    <select name="gen" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Pengguna Kacamata" {{ old('gen', $pemeriksaan->anamnesa->gen) == 'Pengguna Kacamata' ? 'selected' : '' }}>Pengguna Kacamata</option>
                        <option value="Tidak" {{ old('gen', $pemeriksaan->anamnesa->gen) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label">Riwayat</label>
                    <select name="riwayat" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach (['Hipertensi', 'Diabetes', 'Vertigo'] as $r)
                        <option value="{{ $r }}" {{ old('riwayat', $pemeriksaan->anamnesa->riwayat) == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label">Status Kacamata Lama</label>
                    <select name="status_kacamata_lama" class="form-select">
                        @foreach (['tidak dibawa', 'rusak', 'hilang', 'sudah tidak enak'] as $val)
                        <option value="{{ $val }}" {{ old('status_kacamata_lama', $pemeriksaan->status_kacamata_lama) == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-12">
                    <label class="form-label">Lainnya</label>
                    <textarea name="lainnya" class="form-control">{{ old('lainnya', $pemeriksaan->anamnesa->lainnya) }}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">OD</h3>
                    </div>
                    <div class="card-body row">
                        @foreach (['sph','cyl','axis','add','prisma','base'] as $field)
                        <div class="mb-3 col-md-4">
                            <label>{{ strtoupper($field) }}</label>
                            <input type="text" name="od_{{ $field }}" class="form-control"
                                value="{{ old('od_'.$field, $pemeriksaan->{'od_'.$field}) }}" autocomplete="off">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">OS</h3>
                    </div>
                    <div class="card-body row">
                        @foreach (['sph','cyl','axis','add','prisma','base'] as $field)
                        <div class="mb-3 col-md-4">
                            <label>{{ strtoupper($field) }}</label>
                            <input type="text" name="os_{{ $field }}" class="form-control"
                                value="{{ old('os_'.$field, $pemeriksaan->{'os_'.$field}) }}" autocomplete="off">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-secondary card-outline mt-3">
            <div class="card-header">
                <h3 class="card-title">Lainnya</h3>
            </div>
            <div class="card-body row">
                <div class="mb-3 col-md-4">
                    <label>BINOCULER PD</label>
                    <input type="text" name="binoculer_pd" class="form-control"
                        value="{{ old('binoculer_pd', $pemeriksaan->binoculer_pd) }}" autocomplete="off">
                </div>

                <div class="mb-3 col-md-8">
                    <label>Keterangan Kacamata Lama</label>
                    <textarea name="keterangan_kacamata_lama" class="form-control">{{ old('keterangan_kacamata_lama', $pemeriksaan->keterangan_kacamata_lama) }}</textarea>
                </div>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
