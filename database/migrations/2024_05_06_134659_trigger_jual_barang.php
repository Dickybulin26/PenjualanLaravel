<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        DB::unprepared("
            CREATE TRIGGER TrJualBarang AFTER INSERT ON jual FOR EACH ROW
            BEGIN
                UPDATE stok set stok = stok - new.jumlah_jual where id_barang = new.id_barang;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::unprepared("DROP TRIGGER TrJualBarang");
    }
};
