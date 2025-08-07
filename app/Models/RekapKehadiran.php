<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapKehadiran extends Model
{
    use HasFactory;

    protected $table = 'rekap_kehadiran';

    protected $fillable = [
        'id_pegawai',
        'tanggal',
        'jam_datang',
        'jam_pulang',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_datang' => 'datetime:H:i:s',
        'jam_pulang' => 'datetime:H:i:s',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
