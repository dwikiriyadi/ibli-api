<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model{
    protected $table = 'prodi';

    protected $fillable = [
        'kode_prodi', 'nama_prodi'
    ];

    protected $hidden = [

    ];

    public function makul(){
        return $this->hasMany('App\Makul', 'kode_makul');
    }
}