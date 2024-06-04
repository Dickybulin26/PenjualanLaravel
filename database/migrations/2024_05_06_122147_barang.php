<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'barang';
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('id_barang',true,false)->nullable(false);
            $table->string('nama_barang',200)->nullable(false);
            $table->string('kode_barang',100)->nullable(false);
            $table->decimal('harga_barang',10,2,false)->nullable(false);
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists($this->table);
    }
};
