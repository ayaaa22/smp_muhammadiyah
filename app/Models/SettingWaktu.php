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
        'jam_masuk',
        'jam_pulang',
        'keterangan',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
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
        return self::where('hari', $hariIni)->get();
    }
}
