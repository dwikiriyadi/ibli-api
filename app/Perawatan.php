<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model {
    protected $table = 'perawatan';

    protected $fillable = [
        'no_induk', 'kode_barang', 'tgl_perawatan'
    ];

    protected $hidden = [

    ];
}