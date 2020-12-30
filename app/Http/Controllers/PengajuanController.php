<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use PDF;
use Carbon\Carbon;
use App\Jurusan;
use App\Pegawai;
use App\Pengajuan;
use App\Perencanaan;
use App\RencanaPengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Query 
        $title = 'Pengajuan Aset';
        $jurusan = Pegawai::select('Jurusan_ID')->where('User_ID', '=', Auth::user()->id)->first();

        if(Auth::user()->role_id === 2)
        {
            $data = Pengajuan::select('pengajuan.*', 'jurusan.Nama_Jurusan')
                        ->leftJoin('jurusan', 'jurusan.Kode_Jurusan', '=', 'pengajuan.Jurusan_ID')
                        ->orderBy('Tanggal_Pengajuan', 'DESC')
                        ->where('jurusan.Kode_Jurusan', '=', $jurusan->Jurusan_ID)
                        ->get();
        }
        elseif(Auth::user()->role_id === 5 || Auth::user()->role_id === 1)
        {
            $data = Pengajuan::select('pengajuan.*', 'jurusan.Nama_Jurusan')
                        ->leftJoin('jurusan', 'jurusan.Kode_Jurusan', '=', 'pengajuan.Jurusan_ID')
                        ->where('pengajuan.Status', '!=', 1)
                        ->orderBy('Tanggal_Pengajuan', 'DESC')
                        ->get();
        }

        if($request->ajax())
        {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('Status', function($data){
                        if($data->Status === 1)
                            $status = '<div class="text-center"><span class="badge badge-pill badge-secondary">Belum Diajukan</span></div>';
                        elseif($data->Status === 2)
                            $status = '<div class="text-center"><span class="badge badge-pill badge-info">Sedang Diajukan</span></div>';
                        elseif($data->Status === 3) 
                            $status = '<div class="text-center"><span class="badge badge-pill badge-success">Disetujui</span></div>';
                        else
                            $status = '<div class="text-center"><span class="badge badge-pill badge-danger">Tidak Disetujui</span></div>';
                        
                        return $status;
                    })
                    ->editColumn('Tanggal_Pengajuan', function($data){
                        return date('d-m-Y', strtotime($data->Tanggal_Pengajuan));
                    })
                    ->addColumn('Aksi', function($data){
                        if(Auth::user()->role_id === 2)
                        {
                            $aksi = '
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="' . url('/pengajuan/' . $data->Kode_Pengajuan) . '"><i class="dw dw-print"></i> Lihat Surat</a>
                                        <a class="dropdown-item" href="' . url('/pengajuan/' . $data->Kode_Pengajuan . '/edit') . '"><i class="dw dw-edit2"></i> Edit</a>
                                        <a class="dropdown-item" href="#" onclick="ajukan(' . $data->Kode_Pengajuan . ')"><i class="dw dw-inbox-3"></i> Ajukan Surat</a>
                                    </div>
                                </div>
                            ';
                        }else{
                            if($data->Status === 2)
                            {
                                $aksi = '
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="' . url('/pengajuan/' . $data->Kode_Pengajuan) . '"><i class="dw dw-print"></i> Lihat Surat</a>
                                            <a class="dropdown-item" href="#" onclick="setujui(' . $data->Kode_Pengajuan . ')" ><i class="dw dw-checked"></i> Setujui Pengajuan</a>
                                            <a class="dropdown-item" href="#" onclick="tolak(' . $data->Kode_Pengajuan . ')" ><i class="fa fa-window-close"></i> Tolak Pengajuan </a>
                                        </div>
                                    </div>
                                ';
                            }
                            elseif($data->Status === 3)
                            {
                                $aksi = '
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="' . url('/pengajuan/' . $data->Kode_Pengajuan) . '"><i class="dw dw-print"></i> Lihat Surat</a>
                                            <a class="dropdown-item" href="' . url('/aset/create/' . $data->Kode_Pengajuan . '/pengajuan') . '"><i class="dw dw-add"></i> Tambah Aset</a>
                                        </div>
                                    </div>
                                ';
                            }else{
                                $aksi = '
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="' . url('/pengajuan/' . $data->Kode_Pengajuan) . '"><i class="dw dw-print"></i> Lihat Surat</a>
                                        </div>
                                    </div>
                                ';
                            }
                        }
                        
                        return $aksi;
                    })
                    ->rawColumns(['Status', 'Aksi'])
                    ->make(True);
        }

        return view('Pengajuan.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Perencanaan
        $perencanaan = Perencanaan::select('perencanaan.*')
                        ->leftJoin('rencana_pengajuan', 'rencana_pengajuan.Perencanaan_ID', '=', 'perencanaan.Kode_Perencanaan')
                        ->whereNull('rencana_pengajuan.Perencanaan_ID')
                        ->get();

        // Jurusan
        // $jurusan = Jurusan::all();
        $jurusan = Pegawai::select('Jurusan_ID')->where('User_ID', '=', Auth::user()->id)->first();

        $data = array(
            'title' => 'Pengajuan Aset',
            'perencanaan' => $perencanaan,
            'jurusan' => $jurusan,
        );

        return view('Pengajuan.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Pengajuan
        $pengajuan = Pengajuan::create([
            'Nama_Pengajuan' => $request->Nama_Pengajuan,
            'Tanggal_Pengajuan' => Carbon::createFromFormat('d F Y', $request->Tanggal_Pengajuan)->format('Y-m-d'),
            'Status' => 1,
            'Jurusan_ID' => $request->Jurusan,
        ]);

        // Perencanaan
        $perencanaan = $request->input('Perencanaan');
        foreach($perencanaan as $perencanaans)
        {
            RencanaPengajuan::create([
                'Pengajuan_ID' => $pengajuan->Kode_Pengajuan,
                'Perencanaan_ID' => $perencanaans
            ]);
        }

        // return True;
        return redirect('/pengajuan')->with('message', 'Pengajuan telah selesai dibuat');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Query
        $pengajuan = Pengajuan::find($id);
        $data = array(
            'pengajuan' => $pengajuan,
        );

        $pdf = PDF::loadView('Pengajuan.print', compact('data'))
                    ->setPaper('A4');
        return $pdf->stream('surat-pengajuan-aset-' . date('Y-m-d_H-i-s'). '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Query
        $pengajuan = Pengajuan::find($id);
        $perencanaan = Perencanaan::select('perencanaan.*')
                        ->leftJoin('rencana_pengajuan', 'rencana_pengajuan.Perencanaan_ID', '=', 'perencanaan.Kode_Perencanaan')
                        ->where('rencana_pengajuan.Pengajuan_ID', '=', $pengajuan->Kode_Pengajuan)
                        ->get();  

        // Jurusan
        $jurusan = Jurusan::all(); 

        $data = array(
            'title' => 'Pengajuan Aset',
            'perencanaan' => $perencanaan,
            'pengajuan' => $pengajuan,
            'jurusan' => $jurusan,
        );

        return view('Pengajuan.edit', compact('data'));
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
        $pengajuan = Pengajuan::find($id);
        $pengajuan->Nama_Pengajuan = $request->Nama_Pengajuan;
        $pengajuan->Jurusan_ID = $request->Jurusan;
        $pengajuan->Tanggal_Pengajuan = Carbon::createFromFormat('d F Y', $request->Tanggal_Pengajuan)->format('Y-m-d');
        $pengajuan->save();

        return redirect('/pengajuan')->with('message', 'Pengajuan berhasil diubah');
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

    public function ajukan_pengajuan($id)
    {
        $pengajuan = Pengajuan::find($id);
        $pengajuan->Status = 2;
        $pengajuan->save();

        // return redirect('/pengajuan')->with('message', 'Pengajuan berhasil diajukan');
    }

    public function persetujuan($id, $method)
    {
        switch($method)
        {
            case 'Setujui':
                $pengajuan = Pengajuan::find($id);
                $pengajuan->Status = 3;
                $pengajuan->save();
            break;
            
            case 'Tolak':
                $pengajuan = Pengajuan::find($id);
                $pengajuan->Status = 4;
                $pengajuan->save();
            break;

            default:
                return 'none';
            break;
        }
    }
}
