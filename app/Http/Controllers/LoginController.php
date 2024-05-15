<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        //* tampilkan form login
        $data = [
            'title' => 'Halaman Login aplikasi barang',
            'appTitle' => 'PenjualanLaravel'
        ];
        return view('login', $data);
    }

    public function check(Request $request)
    {
        $postData = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($postData)) {
            //* jika login berhasil maka generate session dan redirect ke halaman dashboard
            $request->session()->regenerate();
            if (Auth::user()->level == 'admin') {
                return response([
                    'status' => 'success',
                    'redirect_url' => '/admin'
                ], 200);
            } elseif (Auth::user()->level == 'barang') {
                return response([
                    'status' => 'success',
                    'redirect_url' => '/barang'
                ], 200);
            } elseif (Auth::user()->level == 'beli') {
                return response([
                    'status' => 'success',
                    'redirect_url' => '/beli'
                ], 200);
            } elseif (Auth::user()->level == 'jual') {
                return response([
                    'status' => 'success',
                    'redirect_url' => '/jual'
                ], 200);
            } else {
                return response([
                    'success' => false,
                ], 401);
            }
        } else {
            
        }
    }
    public function logout(Request $request)
    {
        Auth::user()->logout();
        return redirect()->to('login', 302);
    }
}
