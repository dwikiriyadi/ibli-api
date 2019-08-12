<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model {
    protected $table = 'dosen';

    protected $fillable = [
        'no_induk', 'nama_lengkap', 'foto'
    ];

    protected $hidden = [

    ];
}