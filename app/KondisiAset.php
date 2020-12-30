<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KondisiAset extends Model
{
    // Atribut
    protected $table = 'kondisi_aset';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Aset_ID',
        'Pengaduan_ID',
        'Jumlah',
        'Kondisi'
    ];

    // Method

}
