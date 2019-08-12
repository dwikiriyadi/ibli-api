<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model {
    protected $table = 'mahasiswa';

    protected $fillable = [
        'no_induk', 'nama_lengkap', 'kode_kelas', 'foto'
    ];

    protected $hidden = [

    ];

    public function kelas(){
        return $this->belongsTo('App\Kelas', 'kode_kelas', 'kode_kelas');
    }
}