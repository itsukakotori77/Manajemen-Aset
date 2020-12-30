<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    // Local Variable
    protected $table = 'pengajuan';
    protected $primaryKey = 'Kode_Pengajuan';
    protected $fillable = [
        'Nama_Pengajuan',
        'Tanggal_Pengajuan',
        'Status',
        'Jurusan_ID',
    ];

    // Method
    public function perencanaan()
    {
        return $this->belongsToMany(Perencanaan::class, 'rencana_pengajuan', 'Pengajuan_ID', 'Perencanaan_ID');
    }

    public function aset()
    {
        return $this->belongsToMany(Aset::class, 'aset_pengajuan', 'Aset_ID', 'Pengajuan_ID');
    }

}
