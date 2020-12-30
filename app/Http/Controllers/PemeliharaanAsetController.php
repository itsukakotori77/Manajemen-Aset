<?php

namespace App\Http\Controllers;

use Datatables;
use App\PemeliharaanAset;
use App\PenempatanAset;
use App\Aset;
use Illuminate\Http\Request;

class PemeliharaanAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $title = 'Pemeliharaan Aset';
        // $data = PemeliharaanAset::latest()->get();
        $data = PemeliharaanAset::select(
                'pemeliharaan_aset.Kode_Pemeliharaan',
                'pemeliharaan_aset.Status',
                'ruangan.Kode_Ruangan', 
                'ruangan.Nama_Ruangan', 
                'pemeliharaan_aset.Tanggal_Pemeliharaan',
                'aset.Nama_Aset'
            )
            ->leftJoin('penempatan_aset', 'penempatan_aset.id', '=', 'pemeliharaan_aset.Kode_Pemeliharaan')
            ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
            ->leftJoin('aset', 'aset.Kode_Aset', '=', 'penempatan_aset.Aset_ID')
            ->get();

        if($request->ajax())
        {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('Ruangan', function($data){
                        return $data->Kode_Ruangan . ' ' . $data->Nama_Ruangan;
                    })
                    ->editColumn('Tanggal_Pemeliharaan', function($data){
                        return date('d-m-Y', strtotime($data->Tanggal_Pemeliharaan));
                    })
                    ->editColumn('Status', function($data){

                        if($data->Status === 1)
                            $status = '<span class="badge badge-pill badge-secondary">Sedang Diperbaiki</span>';
                        elseif($data->Status === 2)
                            $status = '<span class="badge badge-pill badge-info">Selesai Diperbaiki</span>';
                        else 
                            $status = '<span class="badge badge-pill badge-success">Dikembalikan</span>';
                        
                        return $status;
                    })
                    ->addColumn('Aksi', function($data){

                        if($data->Status === 1)
                            $aksi = 
                            '
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" onclick="selesai(' . $data->Kode_Pemeliharaan . ')" href="#"><i class="dw dw-check"></i> Selesaikan perbaikan</a>
                                    </div>
                                </div>
                            ';
                        elseif($data->Status === 2)
                            $aksi = 
                            '
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" onclick="kembalikan(' . $data->Kode_Pemeliharaan . ')" href="#"><i class="dw dw-return-3"></i> Kembalikan Aset</a>
                                    </div>
                                </div>
                            ';
                        else 
                            $aksi = 'Tidak ada aksi';

                        return $aksi;
                    })
                    ->rawColumns(['Status', 'Aksi'])
                    ->make(True);
        }

        return view('Pemeliharaan.index', compact('title'));
        // return $data;
    }

    public function ubahStatus(Request $request, $id, $method)
    {
        switch($method)
        {
            case 'selesai':

                // Pemeliharan
                $pemeliharaan = PemeliharaanAset::find($id);
                $pemeliharaan->Status = 2;
                $pemeliharaan->save();
                
            break; 
            
            case 'dikembalikan':

                // Pemeliharaan
                $pemeliharaan = PemeliharaanAset::find($id);
                $pemeliharaan->Status = 3;
                $pemeliharaan->save();

                // Penempatan
                $penempatan = PenempatanAset::find($pemeliharaan->Penempatan_ID);
                $penempatan->Status = 4;
                $penempatan->save();
                
            break;
        }
    }

    
}
