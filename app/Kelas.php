<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model {
    protected $table = 'kelas';

    protected $fillable = [
        'kode_kelas', 'kode_prodi', 'abjad_kelas', 'semester'
    ];

    protected $hidden = [

    ];

    public function prodi(){
        return $this->belongsTo('App\Prodi', 'kode_prodi', 'kode_prodi');
    }
}