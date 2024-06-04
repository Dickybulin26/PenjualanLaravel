<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'stok';
    public function up(): void
    {
        //
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('id_stok',true,false)->nullable(false);
            $table->integer('id_barang',false,false)->nullable(false)->index('idBarangStok');
            $table->integer('jumlah',false,false)->nullable(false)->default(0);

            //* foreign key
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade')->onUpdate('cascade');
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
