<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';

    protected $fillable = [
        'no_induk', 'email', 'password', 'role', 'admin', 'api_key'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function mahasiswa(){
        return $this->belongsTo('App\Mahasiswa', 'no_induk', 'no_induk');
    }

    public function dosen(){
        return $this->belongsTo('App\Dosen', 'no_induk', 'no_induk');
    }

    public function teknisi(){
        return $this->belongsTo('App\Teknisi', 'no_induk', 'no_induk');
    }
}
