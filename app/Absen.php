<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = ['id', 'siswa_id', 'kehadiran', 'tanggal'];
    protected $casts = [
        'id' => 'string',
    ];
}
