<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perencanaan extends Model
{
    // Local Variable 
    protected $table = 'perencanaan';
    protected $primaryKey = 'Kode_Perencanaan';
    protected $fillable = [
        'Nama_Perencanaan',
        'Nama_Pengaju',
        'Nama_Aset',
        'Jenis_Aset',
        'Jumlah_Aset',
        'Merek_Aset',
        'Satuan_Harga',
        'Total_Harga',
        'Tanggal_Perencanaan',
        'Alasan',
        'Status',
        'Pegawai_ID',
        'Ruangan_ID',
    ];

    // Function 
    public function pengajuan()
    {
        return $this->belongsToMany(Pengajuan::class, 'rencana_pengajuan', 'Pengajuan_ID', 'Perencanaan_ID');
    }

    
}
