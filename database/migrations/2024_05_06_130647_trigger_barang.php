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
        //* Raw query untuk membuat trigger barang after insert
        DB::unprepared("
            CREATE TRIGGER stokBarangTrigger AFTER INSERT ON barang FOR EACH ROW
            BEGIN
                INSERT INTO stok (id_barang, jumlah) VALUES (new.id_barang, 0);
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        DB::unprepared("DROP TRIGGER stokBarangTrigger");
    }
};
