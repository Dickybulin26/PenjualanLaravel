<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JualModel extends Model
{
    use HasFactory;

    protected $table = 'jual';
    protected $primaryKey = 'id_jual';
    protected $fillable = ['id_jual','id_barang','jumlah_jual','total','tanggal'];
}
