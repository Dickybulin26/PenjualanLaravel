<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredRequestBeli;
use Illuminate\Http\Request;
use App\Models\BeliModel;
use Yajra\DataTables\Facades\DataTables;

class BeliController extends Controller
{
    protected $id_beli;
    protected $id_barang;
    protected $jumlah_beli;
    protected $tanggal;
    protected $harga;
    protected $total;

    /**
     * 
     ** fungsi untuk menambah beli
    */
    public function index(Request $request){
        if($request->ajax()){
            $data = BeliModel::with('barang')->get();
            return DataTables::of($data)->toJson();
        }

        return view('beli.index');
    }

    public function tambahBeli(){
        return view('beli.tambah');
    }
    /**
     ** fungsi untuk menyimpan data beli
     */
    public function simpanBeli(StoredRequestBeli $request){
        
        $data = $request->validated();
        $data['total'] = $request->harga * $request->jumlah_beli;
        $insert = BeliModel::create($data);
        
        if($insert):
            $pesan = [
                'status' => 'success',
                'pesan' => 'pembelian berhasil dilakukan',
            ];
        else:
            $pesan = [
                'status' => 'error',
                'pesan' => 'pembelian gagal dilakukan',
            ];
        endif;

        return response()->json($pesan);
    }
}
