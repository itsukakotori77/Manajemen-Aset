<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //
    protected $table = 'pegawai';
    protected $primaryKey = 'ID_Pegawai';
    protected $fillable = [
        'Nama_Depan',
        'Nama_Belakang',
        'Jenis_Kelamin',
        'Alamat',
        'Agama',
        'Tempat_Lahir',
        'Tanggal_Lahir',
        'Foto',
        'User_ID',
        'Jurusan_ID',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
