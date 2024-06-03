<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
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
    public $timestamps = false;

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

    $data = [
        'BarangDetil' => BarangModel::where('id_barang', $request->id_barang)->first()
    ];

    return view('barang.edit', $data);
    }


    
    public function simpan(StoreBarangRequest $request){
    /**
     * 
     ** fungsi untuk menyimpan data
     */

        $data = $request->validated();
        if($data):
            if(isset($request->id_barang)):
                //* proses update
                $perintah = BarangModel::where('id_barang', $request->id_barang)->update($data);
                if($perintah):
                    $pesan = [
                        'status' => 'success',
                        'pesan' => 'Data Berhasil Diupdate'
                    ];
                else:
                    $pesan = [
                        'status' => 'error',
                        'pesan' => 'Data Gagal Diupdate'
                    ];
                endif;
            else:
                // *proses tambah data baru
                $dataBaru = BarangModel::create($data);
                if($dataBaru):
                    $pesan = [
                        'status' => 'success',
                        'pesan' => 'Data Barang Baru Berhasil Ditambahkan ke Database'
                    ];
                else:
                    $pesan = [
                        'status' => 'error',
                        'pesan' => 'Data Gagal Ditambahkan ke Database'
                    ];
                endif;
            endif;
        else:
            $pesan = [
                'status' => 'error',
                'pesan' => 'Proses Validasi gagal'
            ];
        endif;

        return response()->json($pesan);
    }

    public function delete(Request $request){
        /**
         ** method ini akan menghapus data yang dikirim dari 
         ** form AJAX yang sudah dikonfirmasi.
         */

        $aksiHapus = BarangModel::where('id_barang', $request->id_barang)->delete();
        if ($aksiHapus) {
            $pesan = [
                'status' => 'success',
                'pesan' => 'Data Berhasil Dihapus'
            ];
        } else {
            $pesan = [
                'status' => 'error',
                'pesan' => 'Data Gagal Dihapus'
            ];
        }

        return response()->json($pesan);
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

    public function listBarang(Request $request){
        if($request->filled('term')):
            $data = BarangModel::select(['nama_barang','id_barang'])
            ->where('nama_barang','LIKE','%' . $request->get('q') . '%')->get();

            return response()->json($data);
        endif;
    }
}
