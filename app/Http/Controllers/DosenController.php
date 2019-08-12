<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;

use App\User;

use App\Dosen;

class DosenController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $dosen = app('db')->select("
            SELECT * FROM user, dosen 
            WHERE user.no_induk = dosen.no_induk 
        ");
        return response()->json(['error'=>false, 'result'=>$dosen]);    
    }
}