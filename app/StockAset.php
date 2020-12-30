<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockAset extends Model
{
    // Atribut
    protected $table = 'stock_aset';
    protected $primaryKey = 'ID_Stock';
    protected $fillable = [
        'Aset_ID',
        'Jumlah',
        'Harga'
    ];

    // Method
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'Kode_Aset');
    }
}
