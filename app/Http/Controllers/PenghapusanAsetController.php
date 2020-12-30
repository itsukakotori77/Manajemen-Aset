<?php

namespace App\Http\Controllers;

use Datatables;
use App\PenghapusanAset;
use App\Aset;
use Illuminate\Http\Request;

class PenghapusanAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $title = 'Penghapusan Aset';
        // $data = PenghapusanAset::latest()->get();
        $data = PenghapusanAset::select(
                'penghapusan_aset.Kode_Penghapusan',
                'penghapusan_aset.Tanggal_Penghapusan',
                'ruangan.Kode_Ruangan', 
                'ruangan.Nama_Ruangan', 
                'aset.Nama_Aset'
            )
            ->leftJoin('penempatan_aset', 'penempatan_aset.id', '=', 'penghapusan_aset.Kode_Penghapusan')
            ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
            ->leftJoin('aset', 'aset.Kode_Aset', '=', 'penempatan_aset.Aset_ID')
            ->get();

        $count = count($data);

        if($request->ajax())
        {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('Ruangan', function($data){
                        return $data->Kode_Ruangan . ' ' . $data->Nama_Ruangan;
                    })
                    ->editColumn('Tanggal_Penghapusan', function($data){
                        return date('d-m-Y', strtotime($data->Tanggal_Penghapusan));
                    })
                    ->make(True);
        }

        return view('PenghapusanAset.index', compact('title', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


}
