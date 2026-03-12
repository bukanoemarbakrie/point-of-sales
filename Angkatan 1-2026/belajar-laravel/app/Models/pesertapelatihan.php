<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pesertapelatihan extends Model
{
    protected $table = 'pesertapelatihan';

    protected $fillable = [
        'jurusan',
        'gelombang',
        'nama_lengkap',
        'nik',
        'kartu_keluarga',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_sekolah',
        'kejuruan',
        'nomor_hp',
        'email',
        'aktivitas_saat_ini',
        'status'
    ];
}
