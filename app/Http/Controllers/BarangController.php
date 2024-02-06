<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    protected $id_barang;
    protected $nama_barang;
    protected $kode_barang;
    protected $harga_barang;
    protected $barangModel;

    public function __construct(){
        $this->barangModel = new BarangModel();
    }


    
    public function tambah(){
    /**
     * 
     ** method ini adalah aksi untuk simpan ke table barang
     ** dari form data yang dikirim oleh method tambah
     */

        return view('barang.tambah');
    }
    
    
    public function index(){
    /**
     * 
     ** fungsi untuk menampilkan data barang dari DB menggunakan ajax 
     ** datatables serverside
     ** end point untuk API ada pada function/method databarang()
     */

        return view('barang.index');
    }

    
    public function update(Request $request){
    /**
     * 
     ** method ini akan menampilkan form update/ubah data 
     ** yang akan dikirim  ke method simpan
     */

        
    }


    
    public function simpan(Request $request){
    /**
     * 
     ** fungsi untuk menyimpan data
     */


    }

    public function delete(Request $request){
        /**
         ** method ini akan menghapus data yang dikirim dari 
         ** form AJAX yang sudah dikonfirmasi.
         */


    }

    public function dataBarang(Request $request){
        /**
         ** method ini akan menjadi endpoint API untuk 
         ** Datatable serverable
         */

        if($request->ajax()):
            $data = $this->barangModel->with('stok')->get();
            return DataTables::of($data)->toJson();
        endif;
    }

}
