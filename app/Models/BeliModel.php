<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class BeliModel extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'beli';
    protected $primaryKey = 'id_beli';
    protected $fillable = ['id_barang','jumlah_beli','tanggal','harga','total'];

    public function barang():BelongsTo
    {
        return $this->belongsTo(BarangModel::class,'id_barang','id_barang','inner');
    }
}
