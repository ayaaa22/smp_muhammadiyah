<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_cuti';

    protected $fillable = [
        'id_pegawai',
        'id_jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan_cuti',
        'alasan_penolakan',
        'status',
        'tanggal_validasi_admin',
        'tanggal_persetujuan_kepsek',
    ];

    protected $dates = [
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_validasi_admin',
        'tanggal_persetujuan_kepsek',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class, 'id_jenis_cuti');
    }
}
