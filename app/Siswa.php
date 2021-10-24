<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nis', 'nama_lengkap', 'asal_sekolah', 'jurusan', 'sekolah_id', 'user_id', 'jenis_kelamin'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sekolah()
    {
         return $this->belongsTo('App\Sekolah');
    }
}
