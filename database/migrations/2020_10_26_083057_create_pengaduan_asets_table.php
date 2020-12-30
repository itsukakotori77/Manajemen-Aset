<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduanAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduan_aset', function (Blueprint $table) {
            $table->id('Kode_Pengaduan');
            $table->date('Tanggal_Pengaduan');
            $table->string('Alasan');
            $table->integer('Status');
            $table->integer('Aset_ID');
            // $table->foreign('Aset_ID')->references('Kode_Aset')->on('aset')->onDelete('restrict');
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
        Schema::dropIfExists('pengaduan_aset');
    }
}
