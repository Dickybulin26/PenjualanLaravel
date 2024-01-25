<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeliModel extends Model
{
    use HasFactory;

    protected $table = 'beli';
    protected $primaryKey = 'id_beli';
    protected $fillable = ['id_beli','id_barang','jumlah_beli','total','tanggal'];

}
