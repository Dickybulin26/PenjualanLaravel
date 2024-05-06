<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    protected$table = "jual";
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('id_jual',true,false)->nullable(false);
            $table->integer('id_barang',false,false)->nullable(false)->index('IdBarangJual');
            $table->dateTime('tanggal',0)->default('2024-01-01')->nullable(false);
            $table->integer('jumlah_jual',false,false)->nullable(false)->default(0);
            $table->decimal('harga_barang',10,2,false)->nullable(true);
            $table->decimal('total',10,2,false)->nullable(true);

            //* foreign key
            $table->foreign('id_barang','ConstraintIdBarangJual')->references('id_barang')->on('barang')->onDelete('cascade')->onUpdate('cascade');
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
