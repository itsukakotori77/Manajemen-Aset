<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenempatanAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penempatan_aset', function (Blueprint $table) {
            $table->id();
            $table->integer('Ruangan_ID');
            $table->integer('Aset_ID');
            $table->date('Tanggal_Penempatan');
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
        Schema::dropIfExists('penempatan_aset');
    }
}
