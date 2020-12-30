<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerencanaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perencanaan', function (Blueprint $table) {
            $table->id('Kode_Perencanaan');
            $table->string('Nama_Perencanaan');
            $table->string('Nama_Pengaju');
            $table->string('Nama_Aset');
            $table->integer('Jenis_Aset');
            $table->integer('Jumlah_Aset');
            $table->string('Merek_Aset');
            $table->integer('Satuan_Harga');
            $table->integer('Total_Harga');
            $table->date('Tanggal_Perencanaan');
            $table->string('Alasan');
            $table->integer('Status');
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
        Schema::dropIfExists('perencanaan');
    }
}
