<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $uuid = DB::raw('UUID()');
            $table->uuid('id')->default($uuid)->primary();
            $table->string('siswa_id');
            $table->char('nilai_sikap');
            $table->char('nilai_pengetahuan');
            $table->dateTime('tanggal');
            // $table->primary('id_siswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaians');
    }
}
