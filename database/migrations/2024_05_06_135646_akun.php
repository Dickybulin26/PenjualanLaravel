<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'akun';
    public function up(): void
    {
        //
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('id_akun',true,false)->nullable(false);
            $table->string('username', 200)->nullable(false);
            $table->string('password', 200)->nullable(false);
            $table->enum('level', ['admin', 'barang','beli','jual']);
            $table->timestamps();
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
