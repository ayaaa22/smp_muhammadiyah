<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table = 'izin';
    
    protected $fillable = [
        'id_pegawai',
        'id_jenis_izin',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'alasan',
        'bukti',
        'status',
        'alasan_penolakan',
        'validated_by',
        'validated_at'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'validated_at' => 'datetime'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'id_jenis_izin');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function isDisetujui()
    {
        return $this->status === 'disetujui';
    }
}
