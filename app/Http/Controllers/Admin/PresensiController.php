<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Presensi::with('pegawai.user');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('pegawai_id')) {
            $query->where('id_pegawai', $request->pegawai_id);
        }

        $presensi = $query->orderBy('tanggal', 'desc')->get()->groupBy(['id_pegawai', 'tanggal']);

        // Ambil pegawai yang user-nya punya role 'pegawai', urut berdasarkan nama
        $pegawaiList = Pegawai::whereHas('user', function ($query) {
            $query->where('role', 'pegawai');
        })
            ->with('user') // pastikan eager load nama user
            ->get()
            ->sortBy(function ($pegawai) {
                return $pegawai->user->nama ?? '';
            });

        return view('pages.admin.presensi.index', compact('presensi', 'pegawaiList'));
    }
}
