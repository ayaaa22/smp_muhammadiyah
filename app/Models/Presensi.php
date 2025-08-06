<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'id_pegawai',
        'waktu',
        'jenis',
        'tanggal',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    // ENUM jenis presensi
    const JENIS_DATANG = 'datang';
    const JENIS_PULANG = 'pulang';

    /**
     * Relasi ke Pegawai
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    /**
     * Scope untuk presensi berdasarkan tanggal (tanpa jam)
     */
    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('waktu', $tanggal);
    }

    /**
     * Scope untuk jenis presensi (datang/pulang)
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    /**
     * Format waktu ke jam (H:i)
     */
    public function jam()
    {
        return $this->waktu ? Carbon::parse($this->waktu)->format('H:i') : null;
    }

    /**
     * Format tanggal ke format lokal
     */
    public function tanggal()
    {
        return $this->waktu ? Carbon::parse($this->waktu)->translatedFormat('d F Y') : null;
    }
}
