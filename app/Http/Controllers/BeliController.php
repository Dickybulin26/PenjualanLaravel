<?php

namespace App\Http\Controllers;

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
        
    }
    /**
     * 
     ** fungsi untuk menyimpan data beli
     */
    public function simpanBeli(Request $request){
        
    }
}
