<div class="row">
  <div class="col-md-6">
    <h6 class="fw-bold">Data Pasien</h6>
    <table class="table table-bordered">
      <tr><th>Nama</th><td>{{ $pemeriksaan->anamnesa->pasien->nama }}</td></tr>
      <tr><th>Usia</th><td>{{ $pemeriksaan->anamnesa->pasien->usia }}</td></tr>
      <tr><th>Alamat</th><td>{{ $pemeriksaan->anamnesa->pasien->alamat }}</td></tr>
    </table>
  </div>
  <div class="col-md-6">
    <h6 class="fw-bold">Waktu Pemeriksaan</h6>
    <table class="table table-bordered">
      <tr><th>Mulai</th><td>{{ $pemeriksaan->waktu_mulai->format('d M Y H:i') }}</td></tr>
      <tr><th>Selesai</th><td>{{ $pemeriksaan->waktu_selesai->format('d M Y H:i') }}</td></tr>
      <tr><th>Petugas</th><td>{{ $pemeriksaan->petugas?->name ?? '-' }}</td></tr>
    </table>
  </div>
</div>

<hr>
@php
    function showArray($value) {
        if (is_array($value)) {
            return implode(', ', $value);
        }

        // Kadang disimpan sebagai JSON string, maka decode dulu
        if (is_string($value) && str_starts_with($value, '[')) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) return implode(', ', $decoded);
        }

        return $value ?? '-';
    }
@endphp

<h6 class="fw-bold mt-3">Anamnesa</h6>
<table class="table table-bordered">
  <tr><th>Jarak Jauh</th><td>{{ showArray($pemeriksaan->anamnesa->jauh) }}</td></tr>
  <tr><th>Jarak Dekat</th><td>{{ showArray($pemeriksaan->anamnesa->dekat) }}</td></tr>
  <tr><th>Genetik</th><td>{{ showArray($pemeriksaan->anamnesa->gen) }}</td></tr>
  <tr><th>Riwayat Penyakit</th><td>{{ showArray($pemeriksaan->anamnesa->riwayat) }}</td></tr>
  <tr><th>Keterangan Tambahan</th><td>{{ showArray($pemeriksaan->anamnesa->lainnya) }}</td></tr>
</table>

<hr>

<h6 class="fw-bold">Pemeriksaan Alat (Auto Refractor)</h6>
@include('pemeriksaan.partials._table_mata', ['prefix' => 'od', 'judul' => 'OD (Mata Kanan)', 'color' => 'success'])
@include('pemeriksaan.partials._table_mata', ['prefix' => 'os', 'judul' => 'OS (Mata Kiri)', 'color' => 'warning'])

<hr>

<h6 class="fw-bold">Pemeriksaan Petugas (Manual)</h6>
@include('pemeriksaan.partials._table_mata', ['prefix' => 'pt_od', 'judul' => 'PT OD (Kanan)', 'color' => 'dark'])
@include('pemeriksaan.partials._table_mata', ['prefix' => 'pt_os', 'judul' => 'PT OS (Kiri)', 'color' => 'secondary'])
