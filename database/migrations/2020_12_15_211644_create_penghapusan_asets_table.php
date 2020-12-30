<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenghapusanAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penghapusan_aset', function (Blueprint $table) {
            $table->id('Kode_Penghapusan');
            $table->integer('Pengaduan_ID');
            $table->date('Tanggal_Penghapusan');
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
        Schema::dropIfExists('penghapusan_aset');
    }
}
