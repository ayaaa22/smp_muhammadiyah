<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $fillable = ['id_jabatan', 'id_user', 'nip', 'npwp', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
