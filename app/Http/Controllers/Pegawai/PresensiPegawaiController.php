<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\SettingWaktu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiPegawaiController extends Controller
{
    public function index()
    {
        $pegawaiId = Auth::user()->pegawai->id;

        // Ambil semua data presensi pegawai yang login, urutkan berdasarkan tanggal (terbaru dulu)
        $presensi = Presensi::where('id_pegawai', $pegawaiId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jenis') // pastikan urutan datang dulu lalu pulang
            ->get()
            ->groupBy('tanggal')
            ->map(function ($items) {
                return [
                    'tanggal' => $items->first()->tanggal,
                    'datang' => $items->firstWhere('jenis', 'datang'),
                    'pulang' => $items->firstWhere('jenis', 'pulang'),
                ];
            });

        // Ambil presensi hari ini saja untuk cek apakah tombol datang/pulang harus disable
        $today = Carbon::today()->toDateString();
        $presensiHariIni = Presensi::where('id_pegawai', $pegawaiId)
            ->whereDate('tanggal', $today)
            ->get();

        $sudahPresensiDatang = $presensiHariIni->where('jenis', 'datang')->isNotEmpty();
        $sudahPresensiPulang = $presensiHariIni->where('jenis', 'pulang')->isNotEmpty();

        return view('pages.pegawai.presensi.index', [
            'presensiHariIni' => $presensi,
            'sudahPresensiDatang' => $sudahPresensiDatang,
            'sudahPresensiPulang' => $sudahPresensiPulang,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:datang,pulang',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $pegawaiId = Auth::user()->pegawai->id;
        $tanggal = Carbon::today()->toDateString();
        $jenis = $request->jenis;
        $hariIni = Carbon::now()->translatedFormat('l'); // 'Senin', 'Selasa', dst.

        $sudahPresensi = Presensi::where('id_pegawai', $pegawaiId)
            ->where('jenis', $jenis)
            ->whereDate('tanggal', $tanggal)
            ->exists();

        if ($sudahPresensi) {
            return back()->with('error', 'Presensi ' . $jenis . ' sudah dilakukan hari ini.');
        }

        // Ambil setting waktu untuk hari ini
        $setting = SettingWaktu::where('hari', $hariIni)->first();
        if (!$setting) {
            return back()->with('error', 'Waktu presensi untuk hari ini belum diatur.');
        }

        $now = Carbon::now();

        if ($jenis === 'datang') {
            $mulai = Carbon::parse($setting->jam_masuk_mulai);
            $selesai = Carbon::parse($setting->jam_masuk_selesai);

            if ($now->lt($mulai) || $now->gt($selesai)) {
                return back()->with('error', 'Presensi datang hanya diperbolehkan antara ' . $mulai->format('H:i') . ' - ' . $selesai->format('H:i'));
            }
        }

        if ($jenis === 'pulang') {
            $mulai = Carbon::parse($setting->jam_pulang_mulai);
            $selesai = Carbon::parse($setting->jam_pulang_selesai);

            if ($now->lt($mulai) || $now->gt($selesai)) {
                return back()->with('error', 'Presensi pulang hanya diperbolehkan antara ' . $mulai->format('H:i') . ' - ' . $selesai->format('H:i'));
            }
        }

        // Simpan presensi
        Presensi::create([
            'id_pegawai' => $pegawaiId,
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'waktu' => now(),
        ]);

        return back()->with('success', 'Presensi ' . $jenis . ' berhasil disimpan.');
    }
}
