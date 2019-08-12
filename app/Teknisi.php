<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model {
    protected $table = 'teknisi';

    protected $fillable = [
        'no_induk', 'nama_lengkap', 'foto'
    ];

    protected $hidden = [

    ];

}