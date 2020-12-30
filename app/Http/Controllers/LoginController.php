<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        switch($request->method())
        {
            case 'GET':
                $title = 'Sistem Manajemen Aset | SMKN 5 Bandung';
                return view('Auth.login', compact('title'));
            break;

            case 'POST':

                // Validasi
                $messages = [
                    'username.required' => 'Tolong Masukkan Username',
                    'password.required' => 'Tolong Masukkan Password',
                ];

                // Validasi
                $validator = Validator::make($request->all(), [
                    'password' => 'required|string|max:199'
                ], $messages);
                
                // Cek Kontrol
                if($validator->fails())
                {
                    return back()->withErrors($validator)->withInput();
                }

                // If Super Admin
                elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1, 'role_id' => 1], $request->remember))
                {
                    // return redirect('/dashboard');
                    // return 'Admin';
                    return redirect('/dashboard');
                }

                // If Ketua Kompetensi
                elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1, 'role_id' => 2], $request->remember))
                {
                    // return redirect('/dashboard');
                    // return 'Ketua Kompetensi';
                    return redirect('/dashboard');
                }

                // If Ketua Sarpras
                elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1, 'role_id' => 3], $request->remember))
                {
                    // return redirect('/dashboard');
                    // return 'Ketua Sarpras';
                    return redirect('/dashboard');
                }
                // If Pengguna Aset
                elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1, 'role_id' => 4], $request->remember))
                {
                    // return redirect('/dashboard');
                    // return 'Pengguna Aset';
                    return redirect('/komplen');
                }
                // If TU Sarpras
                elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1, 'role_id' => 5], $request->remember))
                {
                    // return redirect('/dashboard');
                    // return 'TU Sarpras';
                    return redirect('/dashboard');
                }
                // If Guru
                elseif(Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1, 'role_id' => 6], $request->remember))
                {
                    // return redirect('/dashboard');
                    // return 'Guru';
                    return redirect('/dashboard');
                }

                // Redirect Bak
                return back()->with('Status', 'Password salah');

            break;

            default:
                return '404 not found';
            break;
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
