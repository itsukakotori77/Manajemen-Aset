<?php

namespace App\Http\Controllers;

use Datatables;
use Carbon\Carbon;
use App\Aset;
use App\AsetPengajuan;
use App\Ruangan;
use App\PenempatanAset;
use App\StockAset;
use Illuminate\Http\Request;

class PenempatanAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Penempatan Aset';
        // $data = PenempatanAset::latest()->get();
        $data = PenempatanAset::select('penempatan_aset.*', 'ruangan.Kode_Ruangan', 'aset.Nama_Aset')
                ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
                ->leftJoin('aset', 'aset.Kode_Aset', '=', 'penempatan_aset.Aset_ID')
                ->distinct('ruangan.ID_Ruangan')
                ->get();

        if($request->ajax())
        {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('Status', function($data){
                        
                        if($data->Status === 1)
                            $status = '<div class="text-center"><span class="badge badge-pill badge-primary">Baru</span></div>';
                        elseif($data->Status === 2)
                            $status = '<div class="text-center"><span class="badge badge-pill badge-warning">Rusak Ringan</span></div>';
                        elseif($data->Status === 3) 
                            $status = '<div class="text-center"><span class="badge badge-pill badge-info">Sedang Diperbaiki</span></div>';
                        elseif($data->Status === 4) 
                            $status = '<div class="text-center"><span class="badge badge-pill badge-success">Selesai Diperbaiki</span></div>';
                        else
                            $status = '<div class="text-center"><span class="badge badge-pill badge-danger">Rusak Berat</span></div>';
                        
                        return $status;
                    })
                    ->editColumn('Tanggal_Penempatan', function($data){
                        return date('d-m-Y', strtotime($data->Tanggal_Penempatan));
                    })
                    ->addColumn('Aksi', function($data){
                        return 
                            '
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item"  href="' . url('/penempatan/' . $data->id) . '"><i class="dw dw-eye"></i> Statistik Aset</a>
                                    </div>
                                </div>
                            ';
                    })
                    ->rawColumns(['Status', 'Aksi'])
                    ->make(True);
        }

        return view('Penempatan.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aset = Aset::select('aset.*')
                    ->leftJoin('stock_aset', 'stock_aset.Aset_ID', '=', 'aset.Kode_Aset')
                    ->where('stock_aset.Jumlah', '!=', 0)
                    ->get();

        $data = array(
            'title' => 'Penempatan Aset',
            'aset' => $aset,
            'ruangan' => Ruangan::all()
        );

        return view('Penempatan.create', compact('data'));
    }

    public function createPenempatan($id)
    {
        // $aset = Aset::find($id);
        $asetPenempatan = AsetPengajuan::select('aset_pengajuan.Aset_ID', 'aset_pengajuan.Pengajuan_ID', 'perencanaan.Ruangan_ID', 'perencanaan.Jumlah_Aset', 'perencanaan.Nama_Aset')
                            ->leftJoin('rencana_pengajuan', 'rencana_pengajuan.Pengajuan_ID', '=', 'aset_pengajuan.Pengajuan_ID')
                            ->leftJoin('perencanaan', 'perencanaan.Kode_Perencanaan', '=', 'rencana_pengajuan.Perencanaan_ID')
                            ->where('aset_pengajuan.Aset_ID', '=', $id)
                            ->first();

        $data = array(
            'title' => 'Penempatan Aset',
            'aset' => Aset::find($id),
            'aset_penempatan' => $asetPenempatan,
            'ruangan' => Ruangan::all()
        );

        // return $data;
        return view('Penempatan.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if($request->input('Aset') != NULL)
        {
            $aset = $request->input('Aset');
            $jumlah = $request->input('Jumlah');
            foreach($aset as $aset)
            {
                $penempatan = PenempatanAset::create([
                    'Ruangan_ID' => $request->Ruangan,
                    'Aset_ID' => $aset,
                    'Jumlah' => $request->Jumlah,
                    'Tanggal_Penempatan' => Carbon::createFromFormat('d F Y', $request->Tanggal_Penempatan)->format('Y-m-d'), 
                    'Status' => 1
                ]);
    
                $stok = StockAset::where('Aset_ID', $aset)->first();
                $stok->Jumlah = $stok->Jumlah - $request->Jumlah;
                $stok->save();
            }
        }else{

            $penempatan = PenempatanAset::create([
                'Ruangan_ID' => $request->Ruangan,
                'Aset_ID' => $request->Aset_Otomatis,
                'Jumlah' => $request->Jumlah,
                'Tanggal_Penempatan' => Carbon::now()->format('Y-m-d'), 
                'Status' => 1
            ]);

            $stok = StockAset::where('Aset_ID', $request->Aset_Otomatis)->first();
            $stok->Jumlah = $stok->Jumlah - $request->Jumlah;
            $stok->save();
            // return $request;
        }

        return redirect('/aset/data/masuk')->with('message', 'Data aset berhasil ditempatkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ruangan = PenempatanAset::select('ruangan.ID_Ruangan')->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
                ->where('penempatan_aset.id', '=', $id)->first();

        $data = array(
            'title' => 'Penempatan Aset',
            'aset' => PenempatanAset::select('aset.Nama_Aset', 'penempatan_aset.Jumlah')
                ->leftJoin('aset', 'aset.Kode_Aset', '=', 'penempatan_aset.Aset_ID')
                ->where('penempatan_aset.id', '=', $id)->get(),
            'penempatan' => PenempatanAset::select('ruangan.Nama_Ruangan', 'ruangan.Kode_Ruangan')
                ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
                ->where('penempatan_aset.id', '=', $id)->first(),
            'data_aset' => $this->dataBulanan($ruangan->ID_Ruangan),
        );

        return view('Penempatan.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function dataBulanan($id)
    {
        for($i=0; $i<=12; $i++)
        {
            $tanggal = date('Y-'. $i .'-d');
            $query = PenempatanAset::select('Jumlah')->whereBetween('Tanggal_Penempatan', [
                date('Y-m-01', strtotime($tanggal)), 
                date('Y-m-t', strtotime($tanggal))
            ])
            ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
            ->where('ruangan.ID_Ruangan', '=', $id)->get();

            $jumlah = 0;
            foreach($query as $query_data)
            {
                $jumlah += $query_data->Jumlah;
            }

            $data[] = $jumlah;
        }

        return $data;

    }

   
}
