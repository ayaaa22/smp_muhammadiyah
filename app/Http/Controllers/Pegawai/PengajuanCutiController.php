<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    // 1. Pegawai: Lihat daftar cuti
    public function index()
    {
        $pegawai = Auth::user()->pegawai;

        $cuti = PengajuanCuti::where('id_pegawai', $pegawai->id)
            ->with('jenisCuti')
            ->orderByDesc('created_at')
            ->get();

        return view('pages.pegawai.cuti.index', compact('cuti'));
    }

    // 2. Pegawai: Form pengajuan
    public function create()
    {
        $pegawaiId = auth()->user()->pegawai->id;

        $jenisCutiTersedia = JenisCuti::all()->filter(function ($jenis) use ($pegawaiId) {
            $cutiDisetujui = PengajuanCuti::where('id_pegawai', $pegawaiId)
                ->where('id_jenis_cuti', $jenis->id)
                ->where('status', 'disetujui')
                ->get();

            $totalHari = $cutiDisetujui->sum(function ($cuti) {
                return Carbon::parse($cuti->tanggal_mulai)->diffInDays(Carbon::parse($cuti->tanggal_selesai)) + 1;
            });

            return $totalHari < $jenis->max_cuti;
        });
        return view('pages.pegawai.cuti.create', compact('jenisCutiTersedia'));
    }

    // 3. Pegawai: Simpan pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'id_jenis_cuti' => 'required|exists:jenis_cuti,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan_cuti' => 'nullable|string',
        ]);

        $pegawai = Auth::user()->pegawai;

        // Hitung jumlah hari cuti yang diajukan
        $totalHari = now()->parse($request->tanggal_mulai)->diffInDays(now()->parse($request->tanggal_selesai)) + 1;

        // Validasi jatah cuti
        $jenisCuti = JenisCuti::find($request->id_jenis_cuti);
        $sudahDipakai = PengajuanCuti::where('id_pegawai', $pegawai->id)
            ->where('id_jenis_cuti', $jenisCuti->id)
            ->where('status', 'disetujui')
            ->get()
            ->sum(function ($cuti) {
                return now()->parse($cuti->tanggal_mulai)->diffInDays(now()->parse($cuti->tanggal_selesai)) + 1;
            });

        if (($sudahDipakai + $totalHari) > $jenisCuti->max_cuti) {
            return back()->withErrors(['error' => 'Jatah cuti untuk jenis ini sudah habis.']);
        }

        PengajuanCuti::create([
            'id_pegawai' => $pegawai->id,
            'id_jenis_cuti' => $request->id_jenis_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan_cuti' => $request->alasan_cuti,
            'status' => 'pending',
        ]);

        return redirect()->route('cuti.pegawai.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
}
