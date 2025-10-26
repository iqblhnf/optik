@extends('layouts.app')

@section('title', 'Edit Petugas')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h3 class="card-title">Form Edit Petugas</h3>
        </div>

        <form action="{{ route('petugas.update', $petugas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $petugas->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', $petugas->username) }}">
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="">-- Pilih Role --</option>
                        <option value="pemeriksaan" {{ old('role', $petugas->role) == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan</option>
                        <option value="penjualan" {{ old('role', $petugas->role) == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('petugas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection