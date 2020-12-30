<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    //
    protected $table = 'jurusan';
    protected $primaryKey = 'Kode_Jurusan';
    protected $fillable  = [
        'Nama_Jurusan',
    ];

    // Method 
    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'Jurusan_ID');
    }
}
