<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model {
    protected $table = 'jadwal';

    protected $fillable = [
        'kode_makul', 'id', 'kode_kelas', 'kode_ruang', 'jam_masuk', 'jam_keluar'
    ];

    protected $hidden = [

    ];

    public function user() {
        return morphMany('App\User', 'userable');
    }
}