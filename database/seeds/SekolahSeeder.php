<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sekul = [
            ['sekolah_id' => '123456789', 'nama_sekolah' => 'SMKN 1 PADAHERANG'],
            ['sekolah_id' => '987654321', 'nama_sekolah' => 'SMAN 1 CIBINONG']
        ];

        foreach($sekul as $s) {
            DB::table('sekolah')->insert($s);
        }
    }
}
