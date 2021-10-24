<?php

use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siswa = [
            [
                'nis' => '192010184',
                'nama_lengkap' => 'Ibnu Syawal As-Salim',
                'jenis_kelamin' => 'laki-laki',
                'sekolah_id' => '123456789',
                'user_id' => 1,
                'jurusan' => 'Rekayasa Perangkat Lunak'
            ],
            [
                'nis' => '192010185',
                'nama_lengkap' => 'Ajid Solehudin',
                'jenis_kelamin' => 'laki-laki',
                'sekolah_id' => '123456789',
                'user_id' => 2,
                'jurusan' => 'Teknik Komputer dan Jaringan'
            ],
            [
                'nis' => '202010196',
                'nama_lengkap' => 'Fahri Gunadi',
                'jenis_kelamin' => 'laki-laki',
                'sekolah_id' => '987654321',
                'user_id' => 3,
                'jurusan' => 'Ilmu Pengetahuan Sosial'
            ],
            [
                'nis' => '202010197',
                'nama_lengkap' => 'Dafi Maulana',
                'jenis_kelamin' => 'laki-laki',
                'sekolah_id' => '987654321',
                'user_id' => 4,
                'jurusan' => 'Ilmu Pengetahuan Alam'
            ],
            [
                'nis' => '192010182',
                'nama_lengkap' => 'Dela Cipta Darahmi',
                'jenis_kelamin' => 'perempuan',
                'sekolah_id' => '123456789',
                'user_id' => 5,
                'jurusan' => 'Multimedia'
            ],
            [
                'nis' => '192010188',
                'nama_lengkap' => 'Arya Wijaya',
                'jenis_kelamin' => 'laki-laki',
                'sekolah_id' => '123456789',
                'user_id' => 6,
                'jurusan' => 'DKV'
            ],
        ];

        foreach($siswa as $s) {
            DB::table('siswas')->insert($s);
        }
    }
}
