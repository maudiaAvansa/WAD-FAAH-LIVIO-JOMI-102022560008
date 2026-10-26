<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'no_rm',
        'nama',
        'nik',
        'tgl_lahir',
        'jenis_kelamin',
        'gol_darah',
        'no_hp',
        'alamat',
        'kota',
        'darurat_nama',
        'darurat_hubungan',
        'darurat_hp',
    ];
}