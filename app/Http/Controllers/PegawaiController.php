<?php

namespace App\Http\Controllers;

use Datatables;
use App\User;
use App\Pegawai;
use App\Role;
use App\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = Pegawai::latest()->get();
        $data = Pegawai::select('pegawai.*', 'users.status', 'users.username', 'roles.role')
                ->leftJoin('users', 'users.id', '=', 'pegawai.User_ID')
                ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
                ->orderBy('pegawai.created_at', 'DESC')->get();

        if($request->ajax())
        {
            return Datatables::of($data)
                    // ->toJson()
                    ->addIndexColumn()
                    ->addColumn('Nama', function($data){
                        return $data->Nama_Depan . ' ' . $data->Nama_Belakang;
                    })
                    ->editColumn('Jenis_Kelamin', function($data){
                        if($data->Jenis_Kelamin === 1)
                            $jenis_kelamin = 'Laki - laki';
                        else 
                            $jenis_kelamin = 'Perempuan';

                        return $jenis_kelamin;
                    })
                    ->editColumn('Agama', function($data){
                        if($data->Agama === 1)
                            $agama = 'Islam';
                        elseif($data->Agama === 2)
                            $agama = 'Protestan';
                        elseif($data->Agama === 3)
                            $agama = 'Khatolik';
                        elseif($data->Agama === 4)
                            $agama = 'Hindu';
                        elseif($data->Agama === 5)
                            $agama = 'Buddha';
                        else
                            $agama = 'Khonghucu';

                        return $agama;
                    })
                    ->editColumn('Tanggal_Lahir', function($data){
                        return date('d/m/Y', strtotime($data->Tanggal_Lahir));
                    })
                    ->addColumn('Status', function($data){
                        
                        if($data->status === 1)
                            $status = '<span class="badge badge-pill badge-success">Aktif</span>';
                        else
                            $status = '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
                        
                        return $status;
                    })
                    ->editColumn('Foto', function($data){
                        if($data->Foto == '')
                            $foto = '<img src="https://ui-avatars.com/api/?name='. $data->Nama_Depan . '+' . $data->Nama_Belakang . '&background=0D8ABC&color=fff" class="rounded-circle" style="width: 70px; border-radius: 60px;">';
                        else 
                            $foto = '<img src="' . asset('assets/images/foto-user/' . $data->Foto) . '" class="rounded-circle" style="width: 70px; border-radius: 60px;">' ;
                        
                        return $foto;
                    })
                    ->addColumn('Username', function($data){
                        return $data->username;
                    })
                    ->addColumn('Role', function($data){
                        return $data->role;
                    })
                    ->addColumn('Aksi', function($data){
                        return 
                            '
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" onclick="ubahStatus(' . $data->User_ID . ')" href="#"><i class="dw dw-edit2"></i> Ubah Status</a>
                                        <a class="dropdown-item" href="'. url('/pegawai/' . $data->ID_Pegawai . '/edit') .'"><i class="dw dw-edit2"></i> Edit</a>
                                    </div>
                                </div>
                            '
                        ;

                    })
                    ->rawColumns(['Aksi', 'Foto', 'Status'])
                    ->make(True);
        }

        return view('Pegawai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Pengelolaan Pegawai',
            'jurusan' => Jurusan::all(),
        );

        return view('Pegawai.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validation
        $request->validate([
            'Nama_Depan' => 'required',
            'Nama_Belakang' => 'required',
            'Jenis_Kelamin' => 'required',
            'Alamat' => 'required',
            'NIP' => 'required',
            'Tempat_Lahir' => 'required',
            'Tanggal_Lahir' => 'required',
            'Username' => 'required',
            'Email' => 'required',
        ]);


        $dataUser = User::where('email', $request->Email)->orWhere('username', $request->Username)->first();
        if($dataUser)
        {
            if($dataUser->email == $request->Email)
                $message = 'Data email telah ada pada database';
            elseif($dataUser->username == $request->Username)
                $message = 'Data username telah ada pada database';
            else 
                $message = 'Data telah ada pada database';

            return back()->with('message', $message);
        }else{
            // User Objek Add
            $user = new User;
            $user->username = $request->Username;
            $user->email = $request->Email;
            $user->password = Hash::make('pegawai123');
            $user->remember_token = Str::random(60);
            $user->role_id = $request->Role;
            $user->status = 1;
    
            // Upload Gambar
            if($request->file('Foto_Avatar') == '') 
            {
                $avatar = '';
            } else {
                //Change Path of Picture
                $file = $request->file('Foto_Avatar');
                $dt = Carbon::now();
                $acak  = $file->getClientOriginalExtension();
                $fileName = rand(11111,99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak; 
    
                // Croping Picture
                $image_resize = Image::make($file->getRealPath());              
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('assets/images/foto-user/' . $fileName));
                $avatar = $fileName;
            }
            $user->avatar = $avatar;
            $user->save();
    
            // Objek Pegawai
            $request->request->add(['User_ID' => $user->id]);
            $request->request->add(['Foto' => $avatar]);
            $request->request->add(['Jurusan_ID' => $request->Jurusan]);
            $request->request->add(['Tanggal_Lahir' => Carbon::createFromFormat('d F Y', $request->Tanggal_Lahir)->format('Y-m-d')]);
            $pegawai = Pegawai::create($request->all());

            // Return
            $message = 'Data berhasil ditambahkan';
            return redirect('/pegawai')->with('message', $message);
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
        $data = array(
            'pegawai' => $pegawai = Pegawai::find($id),
            'user' => $user = User::where('id', $pegawai->User_ID)->first(),
        );

        return $data;
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
            'pegawai' => $pegawai = Pegawai::find($id),
            'user' => $user = User::where('id', $pegawai->User_ID)->first(),
            'role' => $role = Role::where('role', '!=', 'Admin')->get(),
            'jurusan' => Jurusan::all()
        );

        return view('Pegawai.edit', compact('data'));
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
        // Validation
        $request->validate([
            'Nama_Depan' => 'required',
            'Nama_Belakang' => 'required',
            'Jenis_Kelamin' => 'required',
            'Alamat' => 'required',
            'NIP' => 'required',
            'Tempat_Lahir' => 'required',
            'Tanggal_Lahir' => 'required',
            'Username' => 'required',
            'Email' => 'required',
        ]);

        // Pegawai
        $pegawai = Pegawai::find($id);
        $pegawai->Nama_Depan = $request->Nama_Depan;
        $pegawai->Nama_Belakang = $request->Nama_Belakang;
        $pegawai->Jenis_Kelamin = $request->Jenis_Kelamin;
        $pegawai->Alamat = $request->Alamat;
        $pegawai->NIP = $request->NIP;
        $pegawai->Jurusan_ID = $request->Jurusan;
        $pegawai->Tempat_Lahir = $request->Tempat_Lahir;
        $pegawai->Tanggal_Lahir = Carbon::createFromFormat('d F Y', $request->Tanggal_Lahir)->format('Y-m-d');

        // User
        $user = User::find($pegawai->User_ID);
        $user->username = $request->Username;
        $user->role_id = $request->Role;
        $user->save();

        // Upload Gambar
        if($request->file('Foto_Avatar') != '') 
        {
            //Change Path of Picture
            $file = $request->file('Foto_Avatar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak; 

            // Croping Picture
            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(200, 200);
            $image_resize->save(public_path('assets/images/foto-user/' . $fileName));
            $avatar = $fileName;
            $pegawai->Foto = $avatar;
        } 

        $pegawai->save();

        // Return
        $message = 'Data berhasil diubah';
        return redirect('/pegawai')->with('message', $message);
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
