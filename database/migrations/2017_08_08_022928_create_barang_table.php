<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->primary('kode_barang');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->enum('jenis_barang', ['Laptop', 'Printer', 'Scanner', 'Proyektor']);
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->enum('status_peminjaman', ['Dipinjam', 'Tidak Dipinjam'])->default('Tidak Dipinjam');
            // $table->string('ruang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
