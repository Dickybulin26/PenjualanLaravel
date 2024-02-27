<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $PrimaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'kode_barang', 'harga_barang','Keterangan'];

    public $timestamps = false;

    public function stok():HasOne
    {
        return $this->hasOne(StokModel::class,'id_barang','id_barang');
    }

    public function barang():HasMany
    {
        return $this->hasMany(BeliModel::class,'id_barang','id_barang');
    }
}
