<?php

namespace App\Http\Controllers;

use App\Models\Anamnesa;
use App\Models\Pasien;
use Illuminate\Http\Request;

class AnamnesaController extends Controller
{
    // Tampilkan semua data anamnesa
    public function index()
    {
        $data = Anamnesa::with('pasien')->latest()->get();
        return view('anamnesa.index', compact('data'));
    }

    // Form tambah
    public function create()
    {
        $pasien = Pasien::orderBy('nama')->get();
        return view('anamnesa.create', compact('pasien'));
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id',
            'jauh' => 'required|in:Buram,Berbayang,Jelas',
            'dekat' => 'required|in:Buram,Berbayang,Jelas',
            'gen' => 'required|in:Pengguna Kacamata,Tidak',
            'riwayat' => 'required|in:Hipertensi,Diabetes,Vertigo',
            'lainnya' => 'nullable|string',
        ]);

        Anamnesa::create($request->all());

        return redirect()->route('anamnesa.index')->with('success', 'Data anamnesa berhasil ditambahkan.');
    }

    // Form edit
    public function edit(Anamnesa $anamnesa)
    {
        $pasien = Pasien::orderBy('nama')->get();
        return view('anamnesa.edit', compact('anamnesa', 'pasien'));
    }

    // Simpan update
    public function update(Request $request, Anamnesa $anamnesa)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id',
            'jauh' => 'required|in:Buram,Berbayang,Jelas',
            'dekat' => 'required|in:Buram,Berbayang,Jelas',
            'gen' => 'required|in:Pengguna Kacamata,Tidak',
            'riwayat' => 'required|in:Hipertensi,Diabetes,Vertigo',
            'lainnya' => 'nullable|string',
        ]);

        $anamnesa->update($request->all());

        return redirect()->route('anamnesa.index')->with('success', 'Data anamnesa berhasil diperbarui.');
    }

    // Hapus data
    public function destroy(Anamnesa $anamnesa)
    {
        $anamnesa->delete();
        return redirect()->route('anamnesa.index')->with('success', 'Data anamnesa berhasil dihapus.');
    }
}
