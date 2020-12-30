<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('Auth.profile', compact('user'));
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
        $data_username = User::where('username', '=', $request->Username)->first();

        if($data_username)
        {
            return back()->with('message', 'Username telah tersedia, silahkan gunakan username lain');
        }else{
            $user = User::find($id);
            $user->username = $request->Username;
    
            // If Password
            if($request->Password != '')
                $user->password = Hash::make($request->Password);
    
            // If Avatar
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
                $user->avatar = $avatar;
            }
            // Save
            $user->save();
            return back()->with('message', 'Data profile berhasil diubah !!');
        }
    }

    public function ubahStatus($id)
    {
        $user = User::find($id);

        if($user->status === 1)
            $user->status = 0;
        else 
            $user->status = 1;
        
        $user->save();
    }
}
