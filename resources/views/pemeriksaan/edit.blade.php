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
                    @error('id_pasien') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                @foreach (['jauh', 'dekat'] as $field)
                @php
                $options = $field == 'jauh' ? $jauhOptions : $dekatOptions;
                $value = old($field, $pemeriksaan->anamnesa->$field ?? '');

                // Tambahkan value jika belum ada di option (untuk tagging manual)
                if ($value && !$options->contains($value)) {
                $options->push($value);
                }
                @endphp

                <div class="mb-3 col-md-4">
                    <label class="form-label">{{ ucfirst($field) }}</label>
                    <select name="{{ $field }}" class="form-select select2" data-placeholder="-- Pilih atau ketik --">
                        <option value=""></option>
                        @foreach ($options as $option)
                        <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @endforeach

                @php
                $genVal = old('gen', $pemeriksaan->anamnesa->gen ?? '');
                if ($genVal && !$genetikOptions->contains($genVal)) {
                $genetikOptions->push($genVal);
                }
                @endphp

                <div class="mb-3 col-md-4">
                    <label class="form-label">Genetik</label>
                    <select name="gen" class="form-select select2" data-placeholder="-- Pilih atau ketik --">
                        <option value=""></option>
                        @foreach ($genetikOptions as $option)
                        <option value="{{ $option }}" {{ $genVal == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('gen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-auto">
                    <label class="form-label d-block">Ada Riwayat Penyakit?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                            type="radio"
                            name="ada_riwayat"
                            id="riwayat_ya"
                            value="ya"
                            {{ old('ada_riwayat', $adaRiwayat ? 'ya' : '') == 'ya' ? 'checked' : '' }}>
                        <label class="form-check-label" for="riwayat_ya">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                            type="radio"
                            name="ada_riwayat"
                            id="riwayat_tidak"
                            value="tidak"
                            {{ old('ada_riwayat', $adaRiwayat ? '' : 'tidak') == 'tidak' ? 'checked' : '' }}>
                        <label class="form-check-label" for="riwayat_tidak">Tidak</label>
                    </div>

                    {{-- Error tampil sebagai blok baru --}}
                    @error('ada_riwayat')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input select jika Ya --}}
                <div class="mb-3 col-md-3" id="form-riwayat" style="display: {{ $adaRiwayat ? 'block' : 'none' }};">
                    <label class="form-label">Masukkan Riwayat Penyakit</label>
                    <select name="riwayat"
                        id="riwayat-input"
                        class="form-select @error('riwayat') is-invalid @enderror">
                        <option value="">-- Pilih Penyakit --</option>
                        @foreach($penyakitOptions as $p)
                        <option value="{{ $p }}" {{ (old('riwayat', $riwayatValue ?? '') == $p) ? 'selected' : '' }}>
                            {{ $p }}
                        </option>
                        @endforeach
                        <option value="Lainnya" {{ (old('riwayat', $riwayatValue ?? '') == 'Lainnya') ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('riwayat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Hidden jika Tidak --}}
                <input type="hidden" name="riwayat" value="Tidak" id="hidden-riwayat">

                @php
                $statusVal = old('status_kacamata_lama', $pemeriksaan->status_kacamata_lama ?? '');
                if ($statusVal && !$statusOptions->contains($statusVal)) {
                $statusOptions->push($statusVal);
                }
                @endphp

                <div class="mb-3 col-md-3">
                    <label class="form-label">Status Kacamata Lama</label>
                    <select name="status_kacamata_lama" class="form-select select2" data-placeholder="-- Pilih atau ketik --">
                        <option value=""></option>
                        @foreach ($statusOptions as $option)
                        <option value="{{ $option }}" {{ $statusVal == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('status_kacamata_lama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 col-12">
                    <label class="form-label">Lainnya</label>
                    <textarea name="lainnya" class="form-control">{{ old('lainnya', $pemeriksaan->anamnesa->lainnya) }}</textarea>
                    @error('lainnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Bagian OD / OS --}}
        <div class="row" id="bagian-od-os">

            {{-- ================= OD ================= --}}
            <div class="col-md-6">
                <div class="card card-success card-outline shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">OD (Oculus Dexter - Mata Kanan)</h5>
                    </div>

                    <div class="card-body">

                        {{-- DISTANCE --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="fw-semibold text-success mb-3">DISTANCE (Jarak Jauh)</h6>
                            <div class="row g-3">
                                @foreach (['sph','cyl','axis','prisma','base'] as $field)
                                <div class="col-md-4">
                                    <label class="form-label">{{ strtoupper($field) }}</label>
                                    @if ($field === 'axis')
                                    <div class="input-group">
                                        <input type="text"
                                            name="od_{{ $field }}"
                                            class="form-control"
                                            value="{{ old("od_$field", $pemeriksaan->{'od_'.$field} ?? '') }}"
                                            autocomplete="off">
                                        <span class="input-group-text">°</span>
                                    </div>
                                    @else
                                    <input type="text"
                                        name="od_{{ $field }}"
                                        class="form-control"
                                        value="{{ old("od_$field", $pemeriksaan->{'od_'.$field} ?? '') }}"
                                        autocomplete="off">
                                    @endif

                                    @error("od_$field")
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-semibold text-success mb-3">NEAR (Jarak Dekat)</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">ADD</label>
                                    <input type="text"
                                        name="od_add"
                                        class="form-control"
                                        value="{{ old('od_add', $pemeriksaan->od_add ?? '') }}"
                                        autocomplete="off">
                                    @error('od_add')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================= OS ================= --}}
            <div class="col-md-6">
                <div class="card card-warning card-outline shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">OS (Oculus Sinister - Mata Kiri)</h5>
                    </div>

                    <div class="card-body">

                        {{-- DISTANCE --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="fw-semibold text-warning mb-3">DISTANCE (Jarak Jauh)</h6>
                            <div class="row g-3">
                                @foreach (['sph','cyl','axis','prisma','base'] as $field)
                                <div class="col-md-4">
                                    <label class="form-label">{{ strtoupper($field) }}</label>
                                    @if ($field === 'axis')
                                    <div class="input-group">
                                        <input type="text"
                                            name="os_{{ $field }}"
                                            class="form-control"
                                            value="{{ old("os_$field", $pemeriksaan->{'os_'.$field} ?? '') }}"
                                            autocomplete="off">
                                        <span class="input-group-text">°</span>
                                    </div>
                                    @else
                                    <input type="text"
                                        name="os_{{ $field }}"
                                        class="form-control"
                                        value="{{ old("os_$field", $pemeriksaan->{'os_'.$field} ?? '') }}"
                                        autocomplete="off">
                                    @endif

                                    @error("os_$field")
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- NEAR --}}
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-semibold text-warning mb-3">NEAR (Jarak Dekat)</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">ADD</label>
                                    <input type="text"
                                        name="os_add"
                                        class="form-control"
                                        value="{{ old('os_add', $pemeriksaan->os_add ?? '') }}"
                                        autocomplete="off">
                                    @error('os_add')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="card card-secondary card-outline mt-3">
            <div class="card-header">
                <h3 class="card-title">Lainnya</h3>
            </div>
            <div class="card-body row">
                <div class="mb-3 col-md-6">
                    <label>BINOCULER PD</label>
                    <input type="text" name="binoculer_pd" class="form-control"
                        value="{{ old('binoculer_pd', $pemeriksaan->binoculer_pd ?? 'Tidak Ada') }}" autocomplete="off">
                    @error('binoculer_pd')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                    <div class="input-group">
                        <input type="datetime-local"
                            name="waktu_mulai"
                            id="waktu_mulai"
                            class="form-control"
                            value="{{ old('waktu_mulai', $pemeriksaan->waktu_mulai) }}"
                            readonly>
                        <button class="btn btn-outline-secondary" type="button" id="btn-waktu" disabled>
                            <i class="bi bi-clock-history"></i>
                        </button>
                    </div>
                    @error('waktu_mulai')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="mb-3 col-md-4">
                    <label>Waktu Selesai</label>
                    <input type="datetime-local" name="waktu_selesai" class="form-control" value="{{ old('waktu_selesai', $pemeriksaan->waktu_selesai) }}">
                    @error('waktu_selesai')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div> -->

                <div class="mb-3 col-md-12">
                    <label>Keterangan Kacamata Lama</label>
                    <textarea name="keterangan_kacamata_lama" class="form-control">{{ old('keterangan_kacamata_lama', $pemeriksaan->keterangan_kacamata_lama) }}</textarea>
                    @error('keterangan_kacamata_lama')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Batal</a>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radioYa = document.getElementById('riwayat_ya');
        const radioTidak = document.getElementById('riwayat_tidak');
        const formRiwayat = document.getElementById('form-riwayat');
        const hiddenRiwayat = document.getElementById('hidden-riwayat');
        const inputRiwayat = document.getElementById('riwayat-input');
        const bagianOdOs = document.getElementById('bagian-od-os');

        function toggleRiwayat() {
            if (radioYa.checked) {
                formRiwayat.style.display = 'block';
                inputRiwayat.disabled = false;
                hiddenRiwayat.disabled = true;
                bagianOdOs.style.display = 'flex';
            } else {
                formRiwayat.style.display = 'none';
                inputRiwayat.disabled = true;
                hiddenRiwayat.disabled = false;
                bagianOdOs.style.display = 'none';
            }
        }

        radioYa.addEventListener('change', toggleRiwayat);
        radioTidak.addEventListener('change', toggleRiwayat);
        toggleRiwayat();
    });
</script>

@endsection