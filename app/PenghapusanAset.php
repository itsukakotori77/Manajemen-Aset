<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenghapusanAset extends Model
{
    //
    protected $table = 'penghapusan_aset';
    protected $primaryKey = 'Kode_Penghapusan';
    protected $fillable = [
        'Penempatan_ID',
        'Tanggal_Penghapusan'
    ];
}
