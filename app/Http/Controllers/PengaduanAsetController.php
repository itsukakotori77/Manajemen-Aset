<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Datatables;
use App\Aset;
use App\PengaduanAset;
use App\PenempatanAset;
use App\PemeliharaanAset;
use App\PenghapusanAset;
use Illuminate\Http\Request;

class PengaduanAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Pengaduan Aset';
        // $data = PengaduanAset::latest()->get();
        $data = PengaduanAset::select(
                    'pengaduan_aset.Aset_ID', 
                    'pengaduan_aset.Kode_Pengaduan', 
                    'pengaduan_aset.updated_at',
                    'pengaduan_aset.Alasan',
                    'pengaduan_aset.Tanggal_Pengaduan',
                    'aset.Nama_Aset', 
                    'kondisi_aset.Kondisi'
                )
                ->leftJoin('kondisi_aset', 'kondisi_aset.Pengaduan_ID', '=', 'pengaduan_aset.Kode_Pengaduan')
                ->leftJoin('aset', 'aset.Kode_Aset', '=', 'kondisi_aset.Aset_ID')
                ->orderBy('pengaduan_aset.updated_at', 'DESC')
                ->distinct('pengaduan_aset.Kode_Pengaduan')
                ->get();

        if($request->ajax())
        {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('Kondisi', function($data){
                        
                        if($data->Kondisi === 1)
                        {
                            $kondisi = 'Rusak Ringan';
                        }else{
                            $kondisi = 'Rusak Berat';
                        }

                        return $kondisi;
                    })
                    ->editColumn('Tanggal_Pengaduan', function($data){
                        return date('d-m-Y', strtotime($data->Tanggal_Pengaduan));
                    })
                    ->addColumn('Aksi', function($data){

                        if($data->Kondisi === 1)
                            $aksi = 
                                '
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#" onclick="perbaiki('. $data->Aset_ID .')"><i class="icon-copy dw dw-pin-21"></i> Perbaiki Aset</a>
                                            <a class="dropdown-item" href="#" onclick="hapusAset('. $data->Aset_ID .')"><i class="icon-copy dw dw-delete-1"></i> Hapus Aset</a>
                                        </div>
                                    </div>
                                ';
                        else 
                            $aksi = 
                                '
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#" onclick="hapusAset('. $data->Aset_ID .')"><i class="icon-copy dw dw-delete-1"></i> Hapus Aset</a>
                                        </div>
                                    </div>
                                ';

                        return $aksi;
                    })
                    ->rawColumns(['Aksi'])
                    ->make(True);
        }

        return view('PengaduanAset.index', compact('title'));
    }

    public function ubahStatus(Request $request, $id, $method)
    {
        switch($method)
        {
            case 'ringan':

                // Penempatan
                $penempatan = PenempatanAset::where('Aset_ID', '=', $id)->first();
                $penempatan->Status = 2;
                $penempatan->save();

                // Perbaikan
                PemeliharaanAset::create([
                    'Penempatan_ID' => $penempatan->id,
                    'Tanggal_Pemeliharaan' => Carbon::now()->format('Y-m-d'),
                    'Status' => 1
                ]);

                return response()->json([
                    'status' => 'success', 
                    'data' => $penempatan,
                ]);

            break;

            case 'berat':

                // Penempatan
                $penempatan = PenempatanAset::where('Aset_ID', '=', $id)->first();
                $penempatan->Status = 5;
                $penempatan->save();

                // Penempatan
                PerbaikanAset::create([
                    'Penempatan_ID' => $penempatan->id,
                    'Tanggal_Penempatan' => Carbon::now()->format('Y-m-d')
                 ]);

                return response()->json([
                    'status' => 'success', 
                    'data' => $penempatan,
                ]);

            break;
        }
    }

}
