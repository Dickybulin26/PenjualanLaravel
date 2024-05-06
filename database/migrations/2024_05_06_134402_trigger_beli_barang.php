<?php

use GuzzleHttp\Promise\Create;
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
            CREATE TRIGGER TrBeliBarang AFTER INSERT ON beli FOR EACH ROW
            BEGIN
                UPDATE stok set jumlah = jumlah + new.jumlah_beli where id_barang = new.id_barang;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::unprepared("DROP TRIGGER TrBeliBarang");
    }
};
