@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid">
    <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Optik</h3>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label>Nama Optik</label>
                    <input type="text" name="nama_optik" value="{{ $setting->nama_optik }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Alamat Optik</label>
                    <input type="text" name="alamat_optik" value="{{ $setting->alamat_optik }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Logo</label><br>
                    <input type="file" name="logo" class="form-control">
                    @if($setting->logo)
                        <img src="{{ asset('storage/' . $setting->logo) }}" class="mt-2" height="80">
                    @endif
                </div>

                <div class="mb-3">
                    <label>Background Login</label>
                    <input type="file" name="background" class="form-control">
                    @if($setting->background)
                        <img src="{{ asset('storage/' . $setting->background) }}" class="mt-2" style="width: 200px;">
                    @endif
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection
