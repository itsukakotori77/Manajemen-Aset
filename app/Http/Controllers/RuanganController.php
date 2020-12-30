<?php

namespace App\Http\Controllers;

use Datatables;
use App\Ruangan;
use App\Jurusan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Pengelolaan Ruangan';
        // $data = Ruangan::latest()->get();
        $data = Ruangan::select('ruangan.*', 'jurusan.Nama_Jurusan')
                    ->leftJoin('jurusan', 'jurusan.Kode_Jurusan', '=', 'ruangan.Jurusan_ID')
                    ->get();

        if($request->ajax())
        {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('Jenis_Ruangan', function($data){
                        if($data->Jenis_Ruangan === 1)
                        {
                            $ruangan = 'Ruang Kelas';
                        }else{
                            $ruangan = 'Ruang Praktek';
                        }

                        return $ruangan;
                    })
                    ->addColumn('Jurusan', function($data){
                        return $data->Nama_Jurusan;
                    })
                    ->addColumn('Aksi', function($data){
                        $aksi = 
                        '
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="' . url('/ruangan/' . $data->ID_Ruangan . '/edit') . '"><i class="dw dw-edit2"></i> Edit</a>
                                    <a class="dropdown-item" href="' . url('/ruangan/' . $data->ID_Ruangan) . '"><i class="icon-copy dw dw-delete-1"></i> Hapus</a>
                                </div>
                            </div>
                        ';

                        return $aksi;
                    })
                    ->rawColumns(['Kode_Ruangan', 'Aksi'])
                    ->make(True);
        }

        return view('Ruangan.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Pengelolaan Ruangan',
            'jurusan' => Jurusan::all()
        );
        
        return view('Ruangan.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ruangan = Ruangan::where('Kode_Ruangan', '=', $request->Kode_Ruangan)->first();
        
        if($ruangan)
        {
            return back()->with('message', 'Data ruangan sudah ada di database');
        }else{
            Ruangan::create($request->all());
            return redirect('/ruangan')->with('message', 'Data ruangan berhasil ditambahka');
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
        //
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
            'title' => 'Pengelolaan Ruangan',
            'ruangan' => Ruangan::find($id),
            'jurusan' => Jurusan::all()
        );

        return view('Ruangan.edit', compact('data'));
        // return $data;
        // return response()->json($data);
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
        $ruangan = Ruangan::find($id);
        $ruangan->Kode_Ruangan = $request->Kode_Ruangan;
        $ruangan->Nama_Ruangan = $request->Nama_Ruangan;
        $ruangan->Jenis_Ruangan = $request->Jenis_Ruangan;
        $ruangan->Jurusan_ID = $request->Jurusan_ID;
        $ruangan->save();

        return redirect('/ruangan')->with('message', 'Data ruangan berhasil diubah');

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
