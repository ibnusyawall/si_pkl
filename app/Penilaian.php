<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['id', 'siswa_id', 'nilai_sikap', 'nilai_pengetahuan', 'tanggal'];
}
