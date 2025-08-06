<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingWaktu;
use Illuminate\Http\Request;

class SettingWaktuController extends Controller
{
    public function index()
    {
        $settingWaktu = SettingWaktu::orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_masuk_mulai')
            ->get();

        return view('pages.admin.setting_waktu.index', compact('settingWaktu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_masuk_mulai' => 'required|date_format:H:i',
            'jam_masuk_selesai' => 'required|date_format:H:i|after:jam_masuk_mulai',
            'jam_pulang_mulai' => 'required|date_format:H:i',
            'jam_pulang_selesai' => 'required|date_format:H:i|after:jam_pulang_mulai',
            'keterangan' => 'nullable|string|max:100'
        ]);

        SettingWaktu::create($request->only([
            'hari',
            'jam_masuk_mulai',
            'jam_masuk_selesai',
            'jam_pulang_mulai',
            'jam_pulang_selesai',
            'keterangan'
        ]));

        return redirect()->back()->with('success', 'Waktu presensi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_masuk_mulai' => 'required|date_format:H:i',
            'jam_masuk_selesai' => 'required|date_format:H:i|after:jam_masuk_mulai',
            'jam_pulang_mulai' => 'required|date_format:H:i',
            'jam_pulang_selesai' => 'required|date_format:H:i|after:jam_pulang_mulai',
            'keterangan' => 'nullable|string|max:100'
        ]);

        $waktu = SettingWaktu::findOrFail($id);
        $waktu->update($request->only([
            'hari',
            'jam_masuk_mulai',
            'jam_masuk_selesai',
            'jam_pulang_mulai',
            'jam_pulang_selesai',
            'keterangan'
        ]));

        return redirect()->back()->with('success', 'Waktu presensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $waktu = SettingWaktu::findOrFail($id);
        $waktu->delete();

        return redirect()->back()->with('success', 'Waktu presensi berhasil dihapus.');
    }
}
