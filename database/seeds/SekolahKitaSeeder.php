<?php

use Illuminate\Database\Seeder;

class SekolahKitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sekul = [
            ['id' => '123456789', 'nama_sekolah' => 'SMKN 1 PADAHERANG'],
            ['id' => '987654321', 'nama_sekolah' => 'SMAN 1 CIBINONG']
        ];

        foreach($sekul as $s) {
            DB::table('sekolah')->insert($s);
        }
    }
}
