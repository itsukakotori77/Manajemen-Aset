<?php

namespace App\Http\Controllers;

use App\Aset;
use App\Role;
use App\StockAset;
use Illuminate\Http\Request;

class DataController extends Controller
{
    //
    public function dataRole()
    {
        // return $data = Role::latest()->get();
        return $data = Role::latest()->where('role', '!=', 'Admin')->get();
    }

    public function stockById($id)
    {
        return StockAset::where('Aset_ID', '=', $id)->first();
    }

    public function stockByKode($id)
    {
        $data = Aset::select('stock_aset.Jumlah')
                ->leftJoin('stock_aset', 'stock_aset.Aset_ID', '=', 'aset.Kode_Aset')
                ->where('Kode', '=', $id)->first();

        return response()->json([
            'data' => $data,
            'status' => '400'
        ]);
    }
}
