<?php

use Illuminate\Database\Seeder;

class PenilaianSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tanggal = date('Y-m-d H:i:s');
        $absen = [
            [ 'siswa_id' => '202010196', 'nilai_sikap' => '8.5', 'nilai_pengetahuan' => '8.9', 'tanggal' => $tanggal],
            [ 'siswa_id' => '202010197', 'nilai_sikap' => '8.6', 'nilai_pengetahuan' => '90', 'tanggal' => $tanggal],
            [ 'siswa_id' => '192010184', 'nilai_sikap' => '7.6', 'nilai_pengetahuan' => '8.3', 'tanggal' => $tanggal],
            [ 'siswa_id' => '192010185', 'nilai_sikap' => '8.2', 'nilai_pengetahuan' => '86', 'tanggal' => $tanggal],
            [ 'siswa_id' => '192010182', 'nilai_sikap' => '9.2', 'nilai_pengetahuan' => '9.3', 'tanggal' => $tanggal],
        ];

        foreach($absen as $s) {
            DB::table('penilaians')->insert($s);
        }
    }
}
