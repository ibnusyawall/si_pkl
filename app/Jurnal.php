<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = [
        'siswa_id', 'judul', 'capaian_akhir', 'tanggal',
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
