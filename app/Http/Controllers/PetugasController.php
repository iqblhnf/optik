<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Proteksi role langsung di controller
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Hanya admin.');
            }
            return $next($request);
        });
    }

    /**
     * Tampilkan semua data petugas.
     */
    public function index()
    {
        $data = User::whereIn('role', ['pemeriksaan', 'penjualan'])
            ->orderBy('name')
            ->get();

        return view('petugas.index', compact('data'));
    }

    /**
     * Tampilkan form tambah petugas.
     */
    public function create()
    {
        return view('petugas.create');
    }

    /**
     * Simpan data petugas baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:4|max:100',
            'role' => 'required|in:pemeriksaan,penjualan',
        ]);

        // Generate kode_user unik
        $kodeUser = $this->generateKodeUser($request->name);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'kode_user' => $kodeUser,
            'password' => Hash::make($request->password), // Hash untuk keamanan
            'role' => $request->role, // Set role otomatis
        ]);

        return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit petugas.
     */
    public function edit(User $petuga) // name variabel harus sesuai binding (petuga tunggal)
    {
        return view('petugas.edit', ['petugas' => $petuga]);
    }

    /**
     * Update data petugas.
     */
    public function update(Request $request, User $petuga)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $petuga->id,
            'password' => 'nullable|string|min:4|max:100',
            'role' => 'required|in:pemeriksaan,penjualan',
        ]);

        $petuga->name = $request->name;
        $petuga->username = $request->username;

        if ($request->filled('password')) {
            $petuga->password = Hash::make($request->password);
        }

        // Pastikan role selalu petugas
        $petuga->role = $request->role;

        // Jika nama berubah → generate kode baru unik
        if ($petuga->isDirty('name')) {
            $petuga->kode_user = $this->generateKodeUser($request->name);
        }

        $petuga->save();

        return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Hapus data petugas.
     */
    public function destroy(User $petuga)
    {
        $petuga->delete();
        return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil dihapus.');
    }

    /**
     * Generate kode_user unik 3 huruf dari nama
     * Jika inisial sama sudah ada, ambil kombinasi 3 huruf lain
     * Jika semua kombinasi dipakai, generate 3 huruf random
     */
    private function generateKodeUser($nama)
    {
        $clean = strtoupper(str_replace(' ', '', $nama));
        $length = strlen($clean);

        // Coba semua kombinasi 3 huruf berurutan
        for ($i = 0; $i <= $length - 3; $i++) {
            $kode = substr($clean, $i, 3);
            if (!User::where('kode_user', $kode)->exists()) {
                return $kode;
            }
        }

        // Jika semua kombinasi dari nama sudah dipakai, generate random unik
        do {
            $kode = strtoupper(Str::random(3));
        } while (User::where('kode_user', $kode)->exists());

        return $kode;
    }
}
