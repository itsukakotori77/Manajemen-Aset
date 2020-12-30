<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemeliharaanAset extends Model
{
    //
    protected $table = 'pemeliharaan_aset';
    protected $primaryKey = 'Kode_Pemeliharaan';
    protected $fillable = [
        'Penempatan_ID',
        'Tanggal_Pemeliharaan',
        'Status'
    ];
}
