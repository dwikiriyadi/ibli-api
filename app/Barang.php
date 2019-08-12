<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model {
    protected $table = 'barang';

    protected $fillable = [
        'kode_barang', 'nama_barang', 'jenis_barang', 'kondisi', 'status_peminjaman', 'ruang'
    ];

    protected $hidden = [

    ];
}