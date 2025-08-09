<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCuti;
use App\Models\RekapKehadiran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanCutiController extends Controller
{
    public function index()
    {
        $pengajuanCuti = PengajuanCuti::where(function ($query) {
            $query->where('status', 'pending')
                ->whereNotNull('tanggal_validasi_admin');
        })
            ->orWhere(function ($query) {
                $query->whereNotNull('tanggal_validasi_kepsek')
                    ->where(function ($subQuery) {
                        $subQuery->where('status', 'disetujui')
                            ->orWhere('status', 'ditolak');
                    });
            })
            ->latest()
            ->get();

        return view('pages.kepsek.cuti.index', compact('pengajuanCuti'));
    }

    public function persetujuan($id)
    {
        $cuti = PengajuanCuti::findOrFail($id);

        // Pastikan sudah divalidasi admin
        if (!$cuti->tanggal_validasi_admin) {
            return back()->withErrors(['error' => 'Pengajuan belum divalidasi admin.']);
        }

        DB::beginTransaction();
        try {
            $cuti->update([
                'status' => 'disetujui',
                'tanggal_validasi_kepsek' => now(),
            ]);

            // Update rekap kehadiran
            $tanggal = Carbon::parse($cuti->tanggal_mulai);
            $selesai = Carbon::parse($cuti->tanggal_selesai);

            while ($tanggal->lte($selesai)) {
                RekapKehadiran::updateOrCreate(
                    [
                        'id_pegawai' => $cuti->id_pegawai,
                        'tanggal' => $tanggal->format('Y-m-d')
                    ],
                    [
                        'status' => 'cuti',
                        'keterangan' => $cuti->jenisCuti->nama_cuti,
                    ]
                );
                $tanggal->addDay();
            }

            DB::commit();
            return back()->with('success', 'Pengajuan cuti berhasil disetujui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyetujui cuti.']);
        }
    }

    public function penolakan(Request $request, $id)
    {
        $cuti = PengajuanCuti::findOrFail($id);

        if (!$cuti->tanggal_validasi_admin) {
            return back()->withErrors(['error' => 'Pengajuan belum divalidasi admin.']);
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|max:255'
        ]);

        $cuti->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'tanggal_validasi_kepsek' => now(),
        ]);

        return back()->with('success', 'Pengajuan cuti berhasil ditolak.');
    }
}
