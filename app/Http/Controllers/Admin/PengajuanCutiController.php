<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;

class PengajuanCutiController extends Controller
{
    public function index()
    {
        $pengajuanCuti = PengajuanCuti::with(['pegawai', 'jenisCuti'])
            ->latest()
            ->get();

        return view('pages.admin.cuti.index', compact('pengajuanCuti'));
    }

    public function validasi(Request $request, $id)
    {
        $cuti = PengajuanCuti::findOrFail($id);

        if ($cuti->status !== 'pending') {
            return back()->withErrors(['error' => 'Cuti sudah divalidasi.']);
        }

        $cuti->update([
            'tanggal_validasi_admin' => now(),
        ]);

        return back()->with('success', 'Pengajuan cuti berhasil divalidasi oleh admin.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        $cuti = PengajuanCuti::findOrFail($id);

        if ($cuti->status !== 'pending') {
            return back()->withErrors(['error' => 'Pengajuan cuti sudah diproses sebelumnya.']);
        }

        $cuti->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'tanggal_validasi_admin' => now(),
        ]);

        return back()->with('success', 'Pengajuan cuti berhasil ditolak.');
    }
}
