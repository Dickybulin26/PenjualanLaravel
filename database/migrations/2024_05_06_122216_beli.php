<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'beli';
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('id_beli',true,false)->nullable(false);
            $table->integer('id_barang',false,false)->index('IdBarangBeli')->nullable(false);
            $table->dateTime('tanggal',0)->default('2024-01-01')->nullable(false);
            $table->integer('jumlah_beli',false,false)->nullable(false);
            $table->decimal('harga',10,2,false)->nullable(false);
            $table->decimal('total',10,2,false)->nullable(false);
            $table->timestamps();

            //* foreign key barang
            $table->foreign('id_barang','ConstraintIdBarang')->references('id_barang')->on('barang')->onDelete('cascade')->onUpdate('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
