<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    // Atribut
    protected $table = 'ruangan';
    protected $primaryKey = 'ID_Ruangan';
    protected $fillable = [
        'Kode_Ruangan',
        'Nama_Ruangan',
        'Jenis_Ruangan',
        'Jurusan_ID',
    ];

    // Method 
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::Class, 'Kode_Jurusan');
    }

    public function aset()
    {
        return $this->belongsToMany(Aset::class, 'penempatan_aset', 'Ruangan_ID', 'Aset_ID');
    }
}
