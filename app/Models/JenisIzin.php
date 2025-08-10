<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisIzin extends Model
{
    use HasFactory;
    protected $table = 'jenis_izin';

    protected $fillable = [
        'kode',         
        'nama',         
        'deskripsi',    
        'perlu_bukti',  
        'is_dinas'      
    ];

    protected $casts = [
        'perlu_bukti' => 'boolean',
        'is_dinas' => 'boolean'
    ];

    public function izin()
    {
        return $this->hasMany(Izin::class, 'id_jenis_izin');
    }

    // Scope untuk filter izin dinas
    public function scopeDinas($query)
    {
        return $query->where('is_dinas', true);
    }

    // Scope untuk filter izin yang perlu bukti
    public function scopePerluBukti($query)
    {
        return $query->where('perlu_bukti', true);
    }
}
