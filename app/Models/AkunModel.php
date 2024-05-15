<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as autentikasiUser;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AkunModel extends autentikasiUser
{
    use HasFactory,Notifiable,HasApiTokens;
    protected $table = "akun";
    protected $primaryKey = "id_akun";

    protected $hidden = ['username','password'];
    protected $fillable = ['username','password','level'];
    
}
