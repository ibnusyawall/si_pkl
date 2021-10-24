<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            SekolahKitaSeeder::class,
            SiswaSeeder::class,
            AbsenSampleSeeder::class,
            PenilaianSampleSeeder::class,
        ]);
    }
}
