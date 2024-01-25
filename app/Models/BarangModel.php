<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $PrimaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'kode', 'harga','Keterangan'];

    public $timestamp = false;
}
