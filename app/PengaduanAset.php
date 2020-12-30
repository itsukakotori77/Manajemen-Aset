<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengaduanAset extends Model
{
    // Atribut
    protected $table = 'pengaduan_aset';
    protected $primaryKey = 'Kode_Pengaduan';
    protected $fillable = [
        'Tanggal_Pengaduan',
        'Alasan',
        'Status',
        'Aset_ID',
        'Ruangan_ID',
        'Penempatan_ID'
    ];

    // public 
    
}
