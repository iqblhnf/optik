<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Anamnesa;
use App\Models\Dekat;
use App\Models\Genetik;
use App\Models\Jauh;
use App\Models\Pasien;
use App\Models\Penyakit;
use App\Models\StatusKacamataLama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $data = Pasien::whereHas('pemeriksaans')
            ->with(['pemeriksaans' => fn($q) => $q->orderByDesc('created_at')])
            ->get()
            ->map(function ($pasien) {
                return [
                    'id' => $pasien->id,
                    'nama' => $pasien->nama,
                    'usia' => $pasien->usia,
                    'jenis_kelamin' => $pasien->jenis_kelamin,
                    'alamat' => $pasien->alamat,
                    'jumlah_pemeriksaan' => $pasien->pemeriksaans->count(),
                    'riwayat' => $pasien->pemeriksaans->map(function ($p) {
                        return [
                            'id' => $p->id, // penting untuk Aksi
                            'tgl' => $p->created_at->format('d M Y H:i'),
                            'petugas' => $p->petugas?->name ?? '-',
                            'od_sph' => $p->od_sph,
                            'od_cyl' => $p->od_cyl,
                            'od_axis' => $p->od_axis,
                            'od_add' => $p->od_add,
                            'od_prisma' => $p->od_prisma,
                            'od_base' => $p->od_base,
                            'os_sph' => $p->os_sph,
                            'os_cyl' => $p->os_cyl,
                            'os_axis' => $p->os_axis,
                            'os_add' => $p->os_add,
                            'os_prisma' => $p->os_prisma,
                            'os_base' => $p->os_base,
                            'binoculer_pd' => $p->binoculer_pd,
                            'status_kacamata_lama' => $p->status_kacamata_lama,
                            'keterangan_kacamata_lama' => $p->keterangan_kacamata_lama,
                            'waktu_mulai' => $p->waktu_mulai->format('d M Y H:i'),
                            'waktu_selesai' => $p->waktu_selesai->format('d M Y H:i'),
                        ];
                    })->values(),
                ];
            });

        return view('pemeriksaan.index', compact('data'));
    }

    public function create()
    {
        $pasien = Pasien::orderBy('nama')->get();

        $data['jauhOptions'] = Jauh::pluck('nama');  // Ambil isi tabel `jauh`
        $data['dekatOptions'] = Dekat::pluck('nama'); // Ambil isi tabel `dekat`
        $data['genetikOptions'] = Genetik::pluck('nama');
        $data['statusOptions'] = StatusKacamataLama::pluck('nama');
        $data['penyakitOptions'] = Penyakit::pluck('nama');

        return view('pemeriksaan.create', compact('pasien') + $data);
    }

    public function store(Request $request)
    {
        // Jika pilih "tidak", isi riwayat = "Tidak"
        if ($request->input('ada_riwayat') === 'tidak') {
            $request->merge(['riwayat' => 'Tidak']);
        }

        // Jika binoculer_pd kosong, isi dengan "Tidak Ada"
        if (!$request->filled('binoculer_pd')) {
            $request->merge(['binoculer_pd' => 'Tidak Ada']);
        }

        // 🔹 Waktu selesai otomatis diisi dengan waktu saat data disimpan
        $now = now(); // waktu saat ini
        $request->merge(['waktu_selesai' => $now->format('Y-m-d\TH:i')]);

        // Validasi gabungan
        $request->validate([
            // Validasi Anamnesa
            'id_pasien' => 'required|exists:pasien,id',
            'jauh' => 'required|string|max:100',
            'dekat' => 'required|string|max:100',
            'gen' => 'required|string|max:100',
            'ada_riwayat' => 'required|in:ya,tidak',
            'riwayat' => 'required|string|max:255',
            'lainnya' => 'nullable|string',

            // Validasi Pemeriksaan
            'od_sph' => 'nullable|string|max:10',
            'od_cyl' => 'nullable|string|max:10',
            'od_axis' => 'nullable|integer|between:0,180',
            'od_add' => 'nullable|string|max:10',
            'od_prisma' => 'nullable|string|max:10',
            'od_base' => 'nullable|string|max:10',
            'os_sph' => 'nullable|string|max:10',
            'os_cyl' => 'nullable|string|max:10',
            'os_axis' => 'nullable|integer|between:0,180',
            'os_add' => 'nullable|string|max:10',
            'os_prisma' => 'nullable|string|max:10',
            'os_base' => 'nullable|string|max:10',
            'binoculer_pd' => 'nullable|string|max:255',
            'status_kacamata_lama' => 'required|string|max:100',
            'keterangan_kacamata_lama' => 'nullable|string|max:255',
            'waktu_mulai'   => 'required|date_format:Y-m-d\TH:i',
            // 'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after_or_equal:waktu_mulai',
        ]);

        // Simpan jika nilai tidak ada di tabel
        Jauh::firstOrCreate(['nama' => $request->jauh]);
        Dekat::firstOrCreate(['nama' => $request->dekat]);
        Genetik::firstOrCreate(['nama' => $request->gen]);
        StatusKacamataLama::firstOrCreate(['nama' => $request->status_kacamata_lama]);

        // Simpan data Anamnesa
        $anamnesa = Anamnesa::create([
            'id_pasien' => $request->id_pasien,
            'jauh' => $request->jauh,
            'dekat' => $request->dekat,
            'gen' => $request->gen,
            'riwayat' => $request->riwayat,
            'lainnya' => $request->lainnya,
        ]);

        // Simpan data Pemeriksaan
        Pemeriksaan::create([
            'id_anamnesa' => $anamnesa->id,
            'id_user' => Auth::user()->id,
            'od_sph' => $request->od_sph,
            'od_cyl' => $request->od_cyl,
            'od_axis' => $request->od_axis,
            'od_add' => $request->od_add,
            'od_prisma' => $request->od_prisma,
            'od_base' => $request->od_base,
            'os_sph' => $request->os_sph,
            'os_cyl' => $request->os_cyl,
            'os_axis' => $request->os_axis,
            'os_add' => $request->os_add,
            'os_prisma' => $request->os_prisma,
            'os_base' => $request->os_base,
            'binoculer_pd' => $request->binoculer_pd,
            'status_kacamata_lama' => $request->status_kacamata_lama,
            'keterangan_kacamata_lama' => $request->keterangan_kacamata_lama,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $now,
        ]);

        return redirect()->route('pemeriksaan.index')->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }

    public function edit(Pemeriksaan $pemeriksaan)
    {
        $anamnesa = $pemeriksaan->anamnesa;
        $pasien = Pasien::orderBy('nama')->get();

        // Deteksi apakah riwayat berisi atau 'Tidak'
        $riwayatValue = $anamnesa->riwayat ?? 'Tidak';
        $adaRiwayat = strtolower($riwayatValue) !== 'tidak';

        // Tambahkan juga jika kamu pakai Select2 untuk field dinamis
        $jauhOptions = Jauh::pluck('nama');
        $dekatOptions = Dekat::pluck('nama');
        $genetikOptions = Genetik::pluck('nama');
        $statusOptions = StatusKacamataLama::pluck('nama');
        $penyakitOptions = Penyakit::pluck('nama');

        return view('pemeriksaan.edit', compact(
            'pemeriksaan',
            'anamnesa',
            'pasien',
            'riwayatValue',
            'adaRiwayat',
            'jauhOptions',
            'dekatOptions',
            'genetikOptions',
            'statusOptions',
            'penyakitOptions'
        ));
    }

    public function update(Request $request, Pemeriksaan $pemeriksaan)
    {
        // Jika tidak ada riwayat, isi dengan 'Tidak'
        if ($request->input('ada_riwayat') === 'tidak') {
            $request->merge(['riwayat' => 'Tidak']);
        }

        // Jika binoculer_pd kosong, isi dengan default
        if (!$request->filled('binoculer_pd')) {
            $request->merge(['binoculer_pd' => 'Tidak Ada']);
        }

        // 🔹 Isi otomatis waktu_selesai dengan waktu saat update disimpan
        $now = now();
        $request->merge(['waktu_selesai' => $now->format('Y-m-d\TH:i')]);

        $request->validate([
            // Validasi Anamnesa
            'id_pasien' => 'required|exists:pasien,id',
            'jauh' => 'required|string|max:100',
            'dekat' => 'required|string|max:100',
            'gen' => 'required|string|max:100',
            'ada_riwayat' => 'required|in:ya,tidak',
            'riwayat' => 'required|string|max:255',
            'lainnya' => 'nullable|string',

            // Validasi Pemeriksaan
            'od_sph' => 'nullable|string|max:10',
            'od_cyl' => 'nullable|string|max:10',
            'od_axis' => 'nullable|integer|between:0,180',
            'od_add' => 'nullable|string|max:10',
            'od_prisma' => 'nullable|string|max:10',
            'od_base' => 'nullable|string|max:10',
            'os_sph' => 'nullable|string|max:10',
            'os_cyl' => 'nullable|string|max:10',
            'os_axis' => 'nullable|integer|between:0,180',
            'os_add' => 'nullable|string|max:10',
            'os_prisma' => 'nullable|string|max:10',
            'os_base' => 'nullable|string|max:10',
            'binoculer_pd' => 'nullable|string|max:255',
            'status_kacamata_lama' => 'required|string|max:100',
            'keterangan_kacamata_lama' => 'nullable|string|max:255',
            'waktu_mulai'   => 'required|date_format:Y-m-d\TH:i',
            'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after_or_equal:waktu_mulai',
        ]);

        // Simpan data baru jika tidak ada
        Jauh::firstOrCreate(['nama' => $request->jauh]);
        Dekat::firstOrCreate(['nama' => $request->dekat]);
        Genetik::firstOrCreate(['nama' => $request->gen]);
        StatusKacamataLama::firstOrCreate(['nama' => $request->status_kacamata_lama]);

        // Update data Anamnesa
        $anamnesa = $pemeriksaan->anamnesa;
        $anamnesa->update([
            'id_pasien' => $request->id_pasien,
            'jauh' => $request->jauh,
            'dekat' => $request->dekat,
            'gen' => $request->gen,
            'riwayat' => $request->riwayat,
            'lainnya' => $request->lainnya,
        ]);

        // Update data Pemeriksaan
        $pemeriksaan->update([
            'id_user' => Auth::user()->id,
            'od_sph' => $request->od_sph,
            'od_cyl' => $request->od_cyl,
            'od_axis' => $request->od_axis,
            'od_add' => $request->od_add,
            'od_prisma' => $request->od_prisma,
            'od_base' => $request->od_base,
            'os_sph' => $request->os_sph,
            'os_cyl' => $request->os_cyl,
            'os_axis' => $request->os_axis,
            'os_add' => $request->os_add,
            'os_prisma' => $request->os_prisma,
            'os_base' => $request->os_base,
            'binoculer_pd' => $request->binoculer_pd,
            'status_kacamata_lama' => $request->status_kacamata_lama,
            'keterangan_kacamata_lama' => $request->keterangan_kacamata_lama,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $now,
        ]);

        return redirect()->route('pemeriksaan.index')->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy(Pemeriksaan $pemeriksaan)
    {
        // Simpan referensi ke anamnesa sebelum menghapus pemeriksaan
        $anamnesa = $pemeriksaan->anamnesa;

        // Hapus pemeriksaan
        $pemeriksaan->delete();

        // Jika ada data anamnesa terkait, hapus juga
        if ($anamnesa) {
            $anamnesa->delete();
        }

        return redirect()->route('pemeriksaan.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }

    public function riwayat($id_pasien)
    {
        // Ambil data pasien (untuk ditampilkan di judul atau header)
        $pasien = Pasien::findOrFail($id_pasien);

        // Ambil semua pemeriksaan milik pasien ini
        $data = $pasien->pemeriksaans()
            ->with('anamnesa') // kalau perlu akses data anamnesa
            ->orderByDesc('created_at')
            ->get();

        return view('pemeriksaan.riwayat', compact('pasien', 'data'));
    }

    public function laporan(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Validasi input tanggal
        if ($request->has('tanggal_awal') || $request->has('tanggal_akhir')) {
            $request->validate([
                'tanggal_awal' => 'required|date',
                'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            ]);
        }

        $query = Pemeriksaan::with('anamnesa.pasien')->latest();

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereBetween('created_at', [$tanggal_awal . ' 00:00:00', $tanggal_akhir . ' 23:59:59']);
        }

        $data = $query->get();

        return view('report.index', compact('data', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function print($id)
    {
        // Pemeriksaan saat ini
        $pemeriksaan = Pemeriksaan::with('anamnesa.pasien')->findOrFail($id);

        // Ambil ID pasien dari relasi
        $id_pasien = $pemeriksaan->anamnesa->id_pasien ?? null;

        // Pemeriksaan sebelumnya dari pasien yang sama (bukan hanya anamnesa yg sama)
        $previous = Pemeriksaan::whereHas('anamnesa', function ($query) use ($id_pasien) {
            $query->where('id_pasien', $id_pasien);
        })
            ->where('id', '<', $pemeriksaan->id)
            ->orderByDesc('id')
            ->first();

        return view('pemeriksaan.print', compact('pemeriksaan', 'previous'));
    }
}
