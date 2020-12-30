<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('ID_Pegawai');
            $table->string('Nama_Depan');
            $table->string('Nama_Belakang');
            $table->integer('Jenis_Kelamin');
            $table->string('Alamat');
            $table->integer('Agama');
            $table->integer('User_ID');
            // $table->foreign('User_ID')->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('pegawai');
    }
}
