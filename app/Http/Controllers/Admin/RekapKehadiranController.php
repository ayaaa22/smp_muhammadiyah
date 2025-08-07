<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\RekapKehadiran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapKehadiranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));
        $pegawaiId = $request->input('id_pegawai');

        $tanggalAwal = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth()->toDateString();
        $tanggalAkhir = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth()->toDateString();

        $query = RekapKehadiran::with('pegawai.user')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

        if ($pegawaiId) {
            $query->where('id_pegawai', $pegawaiId);
        }

        // Grouping by pegawai_id -> tanggal
        $rekap = $query->orderBy('tanggal')
            ->get()
            ->groupBy([
                'id_pegawai',
                function ($item) {
                    return $item->tanggal;
                }
            ]);

        $pegawaiList = Pegawai::whereHas('user', function ($query) {
            $query->where('role', 'pegawai');
        })->with('user')->orderBy('nip')->get();

        return view('pages.admin.rekap_kehadiran.index', [
            'rekapKehadiran' => $rekap,
            'pegawaiList' => $pegawaiList,
        ]);
    }
}
