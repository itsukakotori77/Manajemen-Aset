<?php

namespace App\Http\Controllers;

use Datatables;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Intervention\Image\ImageManagerStatic as Image;
use App\StockAset;
use App\Aset;
use App\AsetPengajuan;
use App\Ruangan;
use App\Pengajuan;
use App\PenempatanAset;
use App\KondisiAset;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stok = StockAset::select('stock_aset.*')
                ->leftJoin('aset', 'aset.Kode_Aset', '=', 'stock_aset.Aset_ID')
                ->where('stock_aset.Jumlah', '!=', 0)
                ->get();

        $data = array(
            'aset_tersedia' => count($stok),
            'aset_ditempatkan' => count(PenempatanAset::all()),
            'aset_total' => count(Aset::all()),
        );

        return view('Aset.index', compact('data'));
        // return $data;
    }

    public function data(Request $request, $method)
    {
        $title = 'Data Aset';

        if($method === 'masuk')
        {
            // Query
            $data = Aset::select(
                        'aset.Jenis_Aset', 
                        'aset.Kode_Aset', 
                        'aset.Nama_Aset', 
                        'aset.Tanggal_Masuk',  
                        'aset.Foto',
                        'aset.Jumlah_Aset', 
                        'stock_aset.Jumlah'
                    )
                    ->leftJoin('stock_aset', 'stock_aset.Aset_ID', '=', 'aset.Kode_Aset')
                    ->distinct('aset.Nama_Aset')
                    ->orderBy('aset.Tanggal_Masuk', 'DESC')
                    ->get();

            if($request->ajax())
            {
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->editColumn('Jenis_Aset', function($data){
                            if($data->Jenis_Aset === 1)
                                $jenis = 'Berwujud';
                            else 
                                $jenis = 'Tak Berwujud';
    
                            return $jenis;
                        })
                        ->editColumn('Tanggal_Masuk', function($data){
                            return date('d-m-Y', strtotime($data->Tanggal_Masuk));
                        })
                        ->addColumn('Kondisi', function($data){
                            if($data->Kondisi === 1)
                                $kondisi = 'Rusak Ringan';
                            else                            
                                $kondisi = 'Rusak Berat';
    
                            return 
                                '
                                    <h5 class="font-16">Jumlah : ' . $data->Jumlah . '</h5>
                                    Kondisi : ' . $kondisi . ' 
                                ';
                        })
                        ->addColumn('Foto', function($data){

                            if($data->Foto == '')
                            {
                                $foto = '<img src="' . asset('data/Foto-Aset/asset.png') . '" width="70" height="70" alt="">';
                            }else{
                                $foto = '<img src="' . asset('data/Foto-Aset/' . $data->Foto) . '" width="70" height="70" alt="">';
                            }

                            return $foto;
                        })
                        ->addColumn('Aksi', function($data){
                            return 
                                '
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" onclick="show(' . $data->Kode_Aset . ')" href="#"><i class="dw dw-eye"></i> View</a>
                                            <a class="dropdown-item" href="' . url('/aset/' . $data->Kode_Aset . '/edit') . '"><i class="dw dw-edit2"></i> Edit</a>
                                            <a class="dropdown-item" href="' . url('/penempatan/create/' . $data->Kode_Aset . '/pengajuan') . '"><i class="dw dw-add"></i> Tempatkan Aset</a>
                                        </div>
                                    </div>
                                ';
                        })
                        ->rawColumns(['Status', 'Kondisi', 'Aksi', 'Foto'])
                        ->make(True);
            }

        }else{
            // Query
            $data = PenempatanAset::select(
                        'aset.Jenis_Aset', 
                        'aset.Kode_Aset', 
                        'aset.Nama_Aset', 
                        'aset.Foto',
                        'aset.Tanggal_Masuk', 
                        'penempatan_aset.Jumlah', 
                        'penempatan_aset.Tanggal_Penempatan',
                        'ruangan.Kode_Ruangan', 
                        'kondisi_aset.Kondisi'
                    )
                    ->leftJoin('aset', 'aset.Kode_Aset', '=', 'penempatan_aset.Aset_ID')
                    ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
                    ->leftJoin('kondisi_aset', 'kondisi_aset.Aset_ID', '=', 'penempatan_aset.Aset_ID')
                    ->orderBy('penempatan_aset.Tanggal_Penempatan', 'DESC')
                    ->get();

            if($request->ajax())
            {
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->editColumn('Jenis_Aset', function($data){
                            if($data->Jenis_Aset === 1)
                                $jenis = 'Berwujud';
                            else 
                                $jenis = 'Tak Berwujud';
    
                            return $jenis;
                        })
                        ->editColumn('Tanggal_Masuk', function($data){
                            return date('d-m-Y', strtotime($data->Tanggal_Masuk));
                        })
                        ->addColumn('Jumlah_Penempatan', function($data){
                            return 
                                '
                                    <h5 class="font-16">Ruangan : ' . $data->Kode_Ruangan . '</h5>
                                    Jumlah Aset : ' . $data->Jumlah . ' 
                                ';
                        })
                        ->addColumn('Penempatan_Aset', function($data){
                            return $data->Kode_Ruangan;
                        })
                        ->addColumn('Foto', function($data){

                            if($data->Foto == '')
                            {
                                $foto = '<img src="' . asset('data/Foto-Aset/asset.png') . '" width="70" height="70" alt="">';
                            }else{
                                $foto = '<img src="' . asset('data/Foto-Aset/' . $data->Foto) . '" width="70" height="70" alt="">';
                            }

                            return $foto;
                        })
                        ->addColumn('Aksi', function($data){
                            return 
                            '
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" onclick="show(' . $data->Kode_Aset . ')" href="#"><i class="dw dw-eye"></i> View</a>
                                        <a class="dropdown-item" href="' . url('/aset/' . $data->Kode_Aset . '/edit') . '"><i class="dw dw-edit2"></i> Edit</a>
                                    </div>
                                </div>
                            ';
                        })
                        ->rawColumns(['Status', 'Kondisi', 'Aksi', 'Foto', 'Jumlah_Penempatan'])
                        ->make(True);
            }
        }


        return view('Aset.data', compact('title', 'method'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Pengelolaan Aset',
            'pengajuan' => Pengajuan::all()
        );

        return view('Aset.create', compact('data'));
        // return $data;
    }

    public function createPengajuan($id)
    {
        $pengajuan = Pengajuan::find($id);

        foreach($pengajuan->perencanaan as $perencanaan)
        {
            $perencanaan_cacah[] = array(
                'Nama_Aset' => $perencanaan->Nama_Aset,
                'Jenis_Aset' => $perencanaan->Jenis_Aset,
                'Jumlah_Aset' => $perencanaan->Jumlah_Aset,
                'Merek_Aset' => $perencanaan->Merek_Aset,
                'Satuan_Harga' => $perencanaan->Satuan_Harga,
                'Total_Harga' => $perencanaan->Total_Harga,
                'Tanggal_Perencanaan' => $perencanaan->Tanggal_Perencanaan,
                'Alasan' => $perencanaan->Alasan
            );
        }

        for($i=0; $i<count($perencanaan_cacah); $i++)
        {
            if(count($perencanaan_cacah) > 1)
            {
                if($perencanaan_cacah[$i]['Nama_Aset'] === $perencanaan_cacah[$i+1]['Nama_Aset'])
                {
                    $perencanaan_fix[] = array(
                        'Nama_Aset' => $perencanaan_cacah[$i]['Nama_Aset'],
                        'Jenis_Aset' => $perencanaan_cacah[$i]['Jenis_Aset'],
                        'Jumlah_Aset' => $perencanaan_cacah[$i]['Jumlah_Aset'],
                        'Merek_Aset' => $perencanaan_cacah[$i]['Merek_Aset'],
                        'Satuan_Harga' => $perencanaan_cacah[$i]['Satuan_Harga'],
                        'Total_Harga' => $perencanaan_cacah[$i]['Total_Harga'] + $perencanaan_cacah[$i+1]['Total_Harga'],
                        'Tanggal_Perencanaan' => $perencanaan_cacah[$i]['Tanggal_Perencanaan'],
                        'Alasan' => $perencanaan_cacah[$i]['Alasan']
                    );
                }else{
                    $perencanaan_fix[] = array(
                        'Nama_Aset' => $perencanaan_cacah[$i]['Nama_Aset'],
                        'Jenis_Aset' => $perencanaan_cacah[$i]['Jenis_Aset'],
                        'Jumlah_Aset' => $perencanaan_cacah[$i]['Jumlah_Aset'],
                        'Merek_Aset' => $perencanaan_cacah[$i]['Merek_Aset'],
                        'Satuan_Harga' => $perencanaan_cacah[$i]['Satuan_Harga'],
                        'Total_Harga' => $perencanaan_cacah[$i]['Total_Harga'],
                        'Tanggal_Perencanaan' => $perencanaan_cacah[$i]['Tanggal_Perencanaan'],
                        'Alasan' => $perencanaan_cacah[$i]['Alasan']
                    );
                }
            }else{
                $perencanaan_fix[] = array(
                    'Nama_Aset' => $perencanaan_cacah[$i]['Nama_Aset'],
                    'Jenis_Aset' => $perencanaan_cacah[$i]['Jenis_Aset'],
                    'Jumlah_Aset' => $perencanaan_cacah[$i]['Jumlah_Aset'],
                    'Merek_Aset' => $perencanaan_cacah[$i]['Merek_Aset'],
                    'Satuan_Harga' => $perencanaan_cacah[$i]['Satuan_Harga'],
                    'Total_Harga' => $perencanaan_cacah[$i]['Total_Harga'],
                    'Tanggal_Perencanaan' => $perencanaan_cacah[$i]['Tanggal_Perencanaan'],
                    'Alasan' => $perencanaan_cacah[$i]['Alasan']
                );
            }
        }

        $data = array(
            'title' => 'Pengelolaan Aset',
            'pengajuan' => $perencanaan_fix
        );

        // return view('Aset.create', compact('data'));
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_aset = Aset::where('Kode', '=', $request->Kode)->first();

        if($data_aset)
        {
            return back()->with('message', 'Data Aset telah tersedia, gunakan kode yang berbeda pada proses input data aset');
        }else{
            // Upload Gambar
            if($request->file('Foto_Aset') == '') 
            {
                $Foto = NULL;
            } else {
                //Change Path of Picture
                $file = $request->file('Foto_Aset');
                $dt = Carbon::now();
                $acak  = $file->getClientOriginalExtension();
                $fileName = rand(11111,99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak; 
    
                // Croping Picture
                $image_resize = Image::make($file->getRealPath());              
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('data/Foto-Aset/' . $fileName));
                $Foto = $fileName;
            }
            
            $code = 'QrCode-Aset-' . $request->Kode . '.png';
            $qrcode = new QrCode($request->Kode);
            $request->request->add(['Tanggal_Masuk' => Carbon::createFromFormat('d F Y', $request->Tanggal_Masuk_Input)->format('Y-m-d')]);
            $request->request->add(['Foto' => $Foto]);
            $request->request->add(['Total_Harga' => $request->Total]);
            $request->request->add(['QrCode' => $code]);
            $aset = Aset::create($request->all());
    
            $stock = StockAset::create([
                'Aset_ID' => $aset->Kode_Aset,
                'Jumlah' => $request->Jumlah_Aset,
                'Harga' => $request->Total
            ]);
    
            if($aset)
                $qrcode->writeFile(public_path() . '/data/QrCode-Aset/' . $code);

            // Create Aset Pengajuan
            AsetPengajuan::create([
                'Aset_ID' => $aset->Kode_Aset,
                'Pengajuan_ID' => $request->Pengajuan
            ]);
    
            return redirect('/aset/data/masuk')->with('message', 'Data aset berhasil ditambahkan');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $aset = Aset::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array(
            'title' => 'Pengelolaan Aset',
            'aset' => Aset::find($id),
        );

        return view('Aset.edit', compact('data'));
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
        // Update
        $aset = Aset::find($id);
        $aset->Nama_Aset = $request->Nama_Aset;
        $aset->Jenis_Aset = $request->Jenis_Aset;
        $aset->Merek_Aset = $request->Merek_Aset;
        $aset->Jumlah_Aset = $request->Jumlah_Aset;
        $aset->Harga_Aset = $request->Harga_Aset;
        $aset->Total_Harga = $request->Total;
        $aset->Kondisi_Aset = $request->Kondisi_Aset;
        $aset->Tanggal_Masuk = Carbon::createFromFormat('d F Y', $request->Tanggal_Masuk_Input)->format('Y-m-d');
        $aset->Keterangan = $request->Keterangan;

        // Upload Gambar
        if($request->file('Foto_Aset') == '') 
        {
            $Foto = NULL;
        } else {
            //Change Path of Picture
            $file = $request->file('Foto_Aset');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak; 

            // Croping Picture
            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(200, 200);
            $image_resize->save(public_path('data/Foto-Aset/' . $fileName));
            $Foto = $fileName;
        }
        $aset->Foto = $Foto;
        $aset->save();

        $stock = StockAset::where('Aset_ID', '=', $aset->Kode_Aset)->first();
        $stock->Jumlah = $request->Jumlah_Aset;
        $stock->save();

        return redirect('/aset/data/masuk')->with('message', 'Data aset berhasil ditambahkan');
    }

    public function generateQRcode($id)
    {
        $aset = Aset::find($id);
        $code = 'QrCode-Aset-' . $aset->Kode . '.png';

        // Generate
        $qrcode = new QrCode($aset->Kode);
        $qrcode->writeFile(public_path() . '/data/QrCode-Aset/' . $code);

        // QRcode
        $aset->QrCode = $code;
        $aset->save();

        return $aset;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}

