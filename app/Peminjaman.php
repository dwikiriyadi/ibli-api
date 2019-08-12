<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model {
    protected $table = 'peminjaman';

    protected $fillable = [
        'no_induk', 'kode_barang', 'kode_ruang', 'tgl_pinjam', 'jam_pinjam', 'tgl_kembali','jam_kembali'
    ];

    protected $hidden = [

    ];
}