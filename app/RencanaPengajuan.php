<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RencanaPengajuan extends Model
{
    protected $table = 'rencana_pengajuan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Perencanaan_ID',
        'Pengajuan_ID',
    ];
}
