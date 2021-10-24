<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';
    protected $fillable = ['id', 'nama_sekolah'];
    public function siswas()
    {
        return $this->hasMany('App\Siswa');
    }
}
