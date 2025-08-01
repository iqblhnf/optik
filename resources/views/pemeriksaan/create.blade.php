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
                    <label for="{{ $field }}" class="form-label">{{ ucfirst($field) }}</label>
                    <select name="{{ $field }}" class="form-select select2 @error($field) is-invalid @enderror" data-placeholder="-- Pilih atau ketik --">
                        <option value=""></option>
                        @foreach ($field == 'jauh' ? $jauhOptions : $dekatOptions as $option)
                        <option value="{{ $option }}" {{ old($field) == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @endforeach

                <div class="mb-3 col-md-4">
                    <label class="form-label">Genetik</label>
                    <select name="gen" class="form-select select2 @error('gen') is-invalid @enderror" data-placeholder="-- Pilih atau ketik --">
                        <option value=""></option>
                        @foreach ($genetikOptions as $option)
                        <option value="{{ $option }}" {{ old('gen') == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('gen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Pilihan Ya / Tidak --}}
                <div class="mb-3 col-auto">
                    <label class="form-label d-block">Ada Riwayat Penyakit?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ada_riwayat" id="riwayat_ya" value="ya" {{ old('ada_riwayat') == 'ya' ? 'checked' : '' }}>
                        <label class="form-check-label" for="riwayat_ya">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ada_riwayat" id="riwayat_tidak" value="tidak" {{ old('ada_riwayat') == 'tidak' ? 'checked' : '' }}>
                        <label class="form-check-label" for="riwayat_tidak">Tidak</label>
                    </div>

                    {{-- Error tampil sebagai blok baru --}}
                    @error('ada_riwayat')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input untuk isi riwayat jika Ya --}}
                <div class="mb-3 col-md-3" id="input-riwayat" style="display: none;">
                    <label class="form-label">Masukkan Riwayat Penyakit</label>
                    <input type="text"
                        name="riwayat"
                        id="riwayat-input"
                        class="form-control @error('riwayat') is-invalid @enderror"
                        value="{{ old('riwayat') }}">
                    @error('riwayat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Hidden input untuk "Tidak" --}}
                <input type="hidden" name="riwayat" id="riwayat-hidden" value="Tidak">

                <div class="mb-3 col-md-3">
                    <label class="form-label">Status Kacamata Lama</label>
                    <select name="status_kacamata_lama" class="form-select select2 @error('status_kacamata_lama') is-invalid @enderror" data-placeholder="-- Pilih atau ketik --">
                        <option value=""></option>
                        @foreach ($statusOptions as $val)
                        <option value="{{ $val }}" {{ old('status_kacamata_lama') == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('status_kacamata_lama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-12">
                    <label class="form-label">Lainnya</label>
                    <textarea name="lainnya" class="form-control @error('lainnya') is-invalid @enderror">{{ old('lainnya') }}</textarea>
                    @error('lainnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- OD dan OS --}}
        <div class="row" id="bagian-od-os">
            {{-- OD --}}
            <div class="col-6">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">OD</h3>
                    </div>
                    <div class="card-body row">
                        @foreach (['sph','cyl','axis','add','prisma','base'] as $field)
                        <div class="mb-3 col-md-4">
                            <label>{{ strtoupper($field) }}</label>
                            @if ($field === 'axis')
                            <div class="input-group">
                                <input type="text" name="od_{{ $field }}" class="form-control" value="{{ old("od_$field") }}" autocomplete="off">
                                <span class="input-group-text">°</span>
                            </div>
                            @else
                            <input type="text" name="od_{{ $field }}" class="form-control" value="{{ old("od_$field") }}" autocomplete="off">
                            @endif

                            @error("od_$field")
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- OS --}}
            <div class="col-6">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">OS</h3>
                    </div>
                    <div class="card-body row">
                        @foreach (['sph','cyl','axis','add','prisma','base'] as $field)
                        <div class="mb-3 col-md-4">
                            <label>{{ strtoupper($field) }}</label>
                            @if ($field === 'axis')
                            <div class="input-group">
                                <input type="text" name="os_{{ $field }}" class="form-control" value="{{ old("os_$field") }}" autocomplete="off">
                                <span class="input-group-text">°</span>
                            </div>
                            @else
                            <input type="text" name="os_{{ $field }}" class="form-control" value="{{ old("os_$field") }}" autocomplete="off">
                            @endif

                            @error("os_$field")
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
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
                    @error("$field")
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                @endforeach

                <div class="mb-3 col-md-4">
                    <label>Waktu Mulai</label>
                    <input type="datetime-local" name="waktu_mulai" class="form-control" value="{{ old('waktu_mulai') }}">
                    @error('waktu_mulai')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label>Waktu Selesai</label>
                    <input type="datetime-local" name="waktu_selesai" class="form-control" value="{{ old('waktu_selesai') }}">
                    @error('waktu_selesai')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label>Keterangan Kacamata Lama</label>
                    <textarea name="keterangan_kacamata_lama" class="form-control">{{ old('keterangan_kacamata_lama') }}</textarea>
                    @error('keterangan_kacamata_lama')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radioYa = document.getElementById('riwayat_ya');
        const radioTidak = document.getElementById('riwayat_tidak');
        const inputRiwayatDiv = document.getElementById('input-riwayat');
        const inputRiwayatText = document.getElementById('riwayat-input');
        const hiddenInput = document.getElementById('riwayat-hidden');
        const bagianOdOs = document.getElementById('bagian-od-os');

        function toggleInputRiwayat() {
            if (radioYa.checked) {
                inputRiwayatDiv.style.display = 'block';
                inputRiwayatText.disabled = false;
                hiddenInput.disabled = true;
                bagianOdOs.style.display = 'flex';
            } else {
                inputRiwayatDiv.style.display = 'none';
                inputRiwayatText.disabled = true;
                hiddenInput.disabled = false;
                inputRiwayatText.value = ''; // kosongkan jika tidak
                bagianOdOs.style.display = 'none';
            }
        }

        // Event listener
        radioYa.addEventListener('change', toggleInputRiwayat);
        radioTidak.addEventListener('change', toggleInputRiwayat);

        // Inisialisasi saat load
        toggleInputRiwayat();
    });
</script>

@endsection