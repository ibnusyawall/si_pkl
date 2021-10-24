<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'syawal',
                'email' => 'syawal@local.host',
                'password' => bcrypt('syawal'),
                'role' => 'pembimbing',
                'status' => 'verified',
            ],
            [
                'name' => 'ajid',
                'email' => 'ajid@local.host',
                'password' => bcrypt('ajid'),
                'role' => 'siswa',
                'status' => 'verified',
            ],
            [
                'name' => 'fahri',
                'email' => 'fahri@local.host',
                'password' => bcrypt('fahri'),
                'role' => 'siswa',
                'status' => 'verified',
            ],
            [
                'name' => 'dafi',
                'email' => 'dafi@local.host',
                'password' => bcrypt('dafi'),
                'role' => 'siswa',
                'status' => 'verified',
            ],
            [
                'name' => 'dela',
                'email' => 'dela@local.host',
                'password' => bcrypt('dela'),
                'role' => 'siswa',
                'status' => 'verified',
            ],
            [
                'name' => 'arya',
                'email' => 'arya@local.host',
                'password' => bcrypt('arya'),
                'role' => 'siswa',
                'status' => 'unverified',
            ],
        ];

        foreach($user as $u) {
            DB::table('users')->insert($u);
        }
    }
}
