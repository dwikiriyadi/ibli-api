<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->primary('kode_peminjaman');
            $table->string('kode_peminjaman');
            $table->string('no_induk');
            $table->string('kode_barang');
            // $table->string('kode_ruang');
            $table->string('tgl_pinjam');
            $table->string('jam_pinjam');
            $table->string('tgl_kembali');
            $table->string('jam_kembali');
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
        Schema::dropIfExists('peminjaman');
    }
}
