<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Models\Jauh;
use App\Models\Dekat;
use App\Models\Genetik;
use App\Models\Penyakit;
use App\Models\Anamnesa;
use Illuminate\Support\Facades\DB;




class PasienController extends Controller
{
    // Tampilkan semua pasien
    public function index()
    {
        $data = Pasien::orderBy('created_at', 'desc')->get();
        return view('pasien.index', compact('data'));
    }

    // Form tambah pasien
    public function create()
    {
        return view('pasien.create', [
            'jauhOptions'     => Jauh::pluck('nama'),
            'dekatOptions'    => Dekat::pluck('nama'),
            'genetikOptions'  => Genetik::pluck('nama'),
            'penyakitOptions' => Penyakit::pluck('nama'),
        ]);
    }


    // Simpan data pasien baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'usia' => 'required',
            'jenis_kelamin' => 'required',
            'jauh' => 'required',
            'dekat' => 'required',
            'gen' => 'required',
            'riwayat' => 'nullable',
            'lainnya' => 'nullable',
            'no_rm' => 'nullable|string|max:50|unique:pasien,no_rm', // validasi tambahan
        ]);

        // 🔹 Generate otomatis jika no_rm kosong
        $no_rm = $request->no_rm;
        if (empty($no_rm)) {
            $last = Pasien::orderByDesc('no_rm')->first();
            if ($last && is_numeric($last->no_rm)) {
                $next = str_pad((int)$last->no_rm + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $next = '0001';
            }
            $no_rm = $next;
        }

        // 🔹 Simpan pasien
        $pasien = Pasien::create([
            'no_rm' => $no_rm,
            'nama' => $request->nama,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        // 🔹 Simpan anamnesa
        Anamnesa::create([
            'id_pasien' => $pasien->id,
            'jauh'      => $request->jauh,
            'dekat'     => $request->dekat,
            'gen'       => $request->gen,
            'riwayat'   => json_encode($request->riwayat),
            'lainnya'   => $request->lainnya,
        ]);

        return redirect()->route('pasien.index')->with('success', "Data pasien + anamnesa berhasil ditambahkan (No.RM: {$no_rm})");
    }



    // Tampilkan detail pasien (opsional)
    public function show(Pasien $pasien)
    {
        return view('pasien.show', compact('pasien'));
    }

    // Form edit pasien
    public function edit(Pasien $pasien)
    {
        $data['jauhOptions']      = Jauh::pluck('nama')->toArray();
        $data['dekatOptions']     = Dekat::pluck('nama')->toArray();
        $data['genetikOptions']   = Genetik::pluck('nama')->toArray();
        $data['penyakitOptions']  = Penyakit::pluck('nama')->toArray(); // <-- aman walau tabel kosong

        // Ambil anamnesa pasien jika ada
        $anamnesa = $pasien->anamnesa;

        // supaya tidak error kalau null
        $selectedRiwayat = [];

        if ($anamnesa) {
            if (is_array($anamnesa->riwayat)) {
                $selectedRiwayat = $anamnesa->riwayat;
            } elseif (!empty($anamnesa->riwayat)) {
                $selectedRiwayat = json_decode($anamnesa->riwayat, true) ?? [];
            }
        }

        return view('pasien.edit', compact('pasien', 'anamnesa', 'selectedRiwayat') + $data);
    }




    // Simpan perubahan data pasien
    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'no_rm' => 'nullable|string|max:50|unique:pasien,no_rm,' . $pasien->id,
            'nama' => 'required|string|max:100',
            'usia' => 'required|string|max:25',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'jauh' => 'required|string',
            'dekat' => 'required|string',
            'gen' => 'required|string',
            'riwayat' => 'nullable|array',
            'riwayat.*' => 'string|max:255',
        ]);


        $pasien->update($request->only([
            'no_rm', 'nama', 'usia', 'jenis_kelamin', 'pekerjaan', 'alamat', 'no_telp'
        ]));


        // update anamnesa, jika tidak ada → create
        \App\Models\Anamnesa::updateOrCreate(
            ['id_pasien' => $pasien->id],
            [
                'jauh'    => $request->jauh,
                'dekat'   => $request->dekat,
                'gen'     => $request->gen,
                'riwayat' => json_encode($request->riwayat),
                'lainnya' => $request->lainnya,
            ]
        );

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }


    // Hapus pasien
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
