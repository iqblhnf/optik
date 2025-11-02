<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->only(['nama_optik', 'alamat_optik']);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('images', 'public');
            $data['logo'] = $logo;
        }

        if ($request->hasFile('background')) {
            $background = $request->file('background')->store('images', 'public');
            $data['background'] = $background;
        }

        $setting->update($data);

        return back()->with('success', 'Berhasil disimpan!');
    }
}
