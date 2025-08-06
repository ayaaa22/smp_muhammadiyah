<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingWaktu extends Model
{
    use HasFactory;

    protected $table = 'setting_waktu';

    protected $fillable = [
        'hari',
        'jam_masuk_mulai',
        'jam_masuk_selesai',
        'jam_pulang_mulai',
        'jam_pulang_selesai',
        'keterangan',
    ];

    protected $casts = [
        'jam_masuk_mulai' => 'datetime:H:i',
        'jam_masuk_selesai' => 'datetime:H:i',
        'jam_pulang_mulai' => 'datetime:H:i',
        'jam_pulang_selesai' => 'datetime:H:i',
    ];

    /**
     * Scope untuk ambil setting berdasarkan hari
     */
    public function scopeHari($query, $hari)
    {
        return $query->where('hari', $hari);
    }

    /**
     * Ambil semua setting untuk hari ini
     */
    public static function hariIni()
    {
        $hariIni = now()->translatedFormat('l'); // Contoh: Senin, Selasa, dst
        return self::where('hari', $hariIni)->first();
    }
}
