<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsetPengajuan extends Model
{
    //
    protected $table = 'aset_pengajuan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Aset_ID',
        'Pengajuan_ID'
    ];
}
