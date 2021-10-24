<?php

use Illuminate\Database\Seeder;

class AbsenSampleSeeder extends Seeder
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
            [ 'siswa_id' => '202010196', 'kehadiran' => 'alfa', 'tanggal' => $tanggal],
            [ 'siswa_id' => '202010197', 'kehadiran' => 'hadir', 'tanggal' => $tanggal],
            [ 'siswa_id' => '192010184', 'kehadiran' => 'izin', 'tanggal' => $tanggal],
            [ 'siswa_id' => '192010185', 'kehadiran' => 'hadir', 'tanggal' => $tanggal],
            [ 'siswa_id' => '192010182', 'kehadiran' => 'sakit', 'tanggal' => $tanggal],
        ];

        foreach($absen as $s) {
            DB::table('absens')->insert($s);
        }
    }
}
