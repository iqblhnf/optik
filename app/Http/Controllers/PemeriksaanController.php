<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Anamnesa;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
{
    public function index()
    {
        $data = Pasien::whereHas('pemeriksaans') // hanya pasien yang punya pemeriksaan
            ->with(['pemeriksaans' => fn($q) => $q->orderByDesc('created_at')])
            ->get()
            ->map(function ($pasien) {
                return (object)[
                    'id' => $pasien->id,
                    'nama' => $pasien->nama,
                    'usia' => $pasien->usia,
                    'jenis_kelamin' => $pasien->jenis_kelamin,
                    'alamat' => $pasien->alamat,
                    'jumlah_pemeriksaan' => $pasien->pemeriksaans->count(),
                    'terakhir_pemeriksaan' => optional($pasien->pemeriksaans->first())->created_at,
                ];
            });

        return view('pemeriksaan.index', compact('data'));
    }

    public function create()
    {
        $pasien = Pasien::orderBy('nama')->get();
        return view('pemeriksaan.create', compact('pasien'));
    }

    public function store(Request $request)
    {
        // Validasi gabungan
        $request->validate([
            // Validasi Anamnesa
            'id_pasien' => 'required|exists:pasien,id',
            'jauh' => 'required|in:Buram,Berbayang,Jelas',
            'dekat' => 'required|in:Buram,Berbayang,Jelas',
            'gen' => 'required|in:Pengguna Kacamata,Tidak',
            'riwayat' => 'required|in:Hipertensi,Diabetes,Vertigo',
            'lainnya' => 'nullable|string',

            // Validasi Pemeriksaan
            'od_sph' => 'required|string|max:10',
            'od_cyl' => 'required|string|max:10',
            'od_axis' => 'required|string|max:10',
            'od_add' => 'required|string|max:10',
            'od_prisma' => 'required|string|max:10',
            'od_base' => 'required|string|max:10',
            'os_sph' => 'required|string|max:10',
            'os_cyl' => 'required|string|max:10',
            'os_axis' => 'required|string|max:10',
            'os_add' => 'required|string|max:10',
            'os_prisma' => 'required|string|max:10',
            'os_base' => 'required|string|max:10',
            'binoculer_pd' => 'required|string|max:10',
            'status_kacamata_lama' => 'required|in:tidak dibawa,rusak,hilang,sudah tidak enak',
            'keterangan_kacamata_lama' => 'required|string|max:255',
        ]);

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
        ]);

        return redirect()->route('pemeriksaan.index')->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }

    public function edit(Pemeriksaan $pemeriksaan)
    {
        $anamnesa = $pemeriksaan->anamnesa;
        $pasien = Pasien::orderBy('nama')->get();

        return view('pemeriksaan.edit', compact('pemeriksaan', 'anamnesa', 'pasien'));
    }

    public function update(Request $request, Pemeriksaan $pemeriksaan)
    {
        $request->validate([
            // Validasi Anamnesa
            'id_pasien' => 'required|exists:pasien,id',
            'jauh' => 'required|in:Buram,Berbayang,Jelas',
            'dekat' => 'required|in:Buram,Berbayang,Jelas',
            'gen' => 'required|in:Pengguna Kacamata,Tidak',
            'riwayat' => 'required|in:Hipertensi,Diabetes,Vertigo',
            'lainnya' => 'nullable|string',

            // Validasi Pemeriksaan
            'od_sph' => 'nullable|string|max:10',
            'od_cyl' => 'nullable|string|max:10',
            'od_axis' => 'nullable|string|max:10',
            'od_add' => 'nullable|string|max:10',
            'od_prisma' => 'nullable|string|max:10',
            'od_base' => 'nullable|string|max:10',
            'os_sph' => 'nullable|string|max:10',
            'os_cyl' => 'nullable|string|max:10',
            'os_axis' => 'nullable|string|max:10',
            'os_add' => 'nullable|string|max:10',
            'os_prisma' => 'nullable|string|max:10',
            'os_base' => 'nullable|string|max:10',
            'binoculer_pd' => 'nullable|string|max:10',
            'status_kacamata_lama' => 'required|in:tidak dibawa,rusak,hilang,sudah tidak enak',
            'keterangan_kacamata_lama' => 'nullable|string|max:255',
        ]);

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
        ]);

        return redirect()->route('pemeriksaan.riwayat', $anamnesa->id_pasien)->with('success', 'Data pemeriksaan berhasil diperbarui.');
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
