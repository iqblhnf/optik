@extends('layouts.app')

@section('title', 'Tambah Pemeriksaan')

@section('content')
<div class="container-fluid">
    <form action="{{ route('pemeriksaan.store') }}" method="POST">
        @csrf
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title">Anamnesa</h3>
            </div>
            <div class="card-body row">
                <div class="mb-3 col-md-4">
                    <label for="id_pasien" class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select @error('id_pasien') is-invalid @enderror select2">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pasien as $p)
                        <option value="{{ $p->id }}" {{ old('id_pasien') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_pasien') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                @foreach (['jauh', 'dekat'] as $field)
                <div class="mb-3 col-md-4">
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

                <div class="mb-3 col-md-4">
                    <label class="form-label">Genetik</label>
                    <select name="gen" class="form-select @error('gen') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Pengguna Kacamata" {{ old('gen') == 'Pengguna Kacamata' ? 'selected' : '' }}>Pengguna Kacamata</option>
                        <option value="Tidak" {{ old('gen') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('gen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label">Riwayat</label>
                    <select name="riwayat" class="form-select @error('riwayat') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach (['Hipertensi', 'Diabetes', 'Vertigo'] as $r)
                        <option value="{{ $r }}" {{ old('riwayat') == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                    @error('riwayat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label">Status Kacamata Lama</label>
                    <select name="status_kacamata_lama" class="form-select" required>
                        @foreach (['tidak dibawa', 'rusak', 'hilang', 'sudah tidak enak'] as $val)
                        <option value="{{ $val }}" {{ old('status_kacamata_lama') == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-12">
                    <label class="form-label">Lainnya</label>
                    <textarea name="lainnya" class="form-control @error('lainnya') is-invalid @enderror">{{ old('lainnya') }}</textarea>
                    @error('lainnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        @foreach ([
                        'sph','cyl','axis','add',
                        'prisma','base'
                        ] as $field)
                        <div class="mb-3 col-md-4">
                            <label>{{ strtoupper(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" name="od_{{ $field }}" class="form-control" value="{{ old($field) }}" autocomplete="off">
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
                        @foreach ([
                        'sph','cyl','axis','add',
                        'prisma','base'
                        ] as $field)
                        <div class="mb-3 col-md-4">
                            <label>{{ strtoupper(str_replace('_', ' ', $field)) }}</label>
                            <input type="text" name="os_{{ $field }}" class="form-control" value="{{ old($field) }}" autocomplete="off">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-secondary card-outline mt-3">
            <div class="card-header">
                <h3 class="card-title">Lainnya.</h3>
            </div>
            <div class="card-body row">
                @foreach ([
                'binoculer_pd'
                ] as $field)
                <div class="mb-3 col-md-4">
                    <label>{{ strtoupper(str_replace('_', ' ', $field)) }}</label>
                    <input type="text" name="{{ $field }}" class="form-control" value="{{ old($field) }}" autocomplete="off">
                </div>
                @endforeach

                <div class="mb-3 col-md-8">
                    <label>Keterangan Kacamata Lama</label>
                    <textarea name="keterangan_kacamata_lama" class="form-control">{{ old('keterangan_kacamata_lama') }}</textarea>
                </div>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection