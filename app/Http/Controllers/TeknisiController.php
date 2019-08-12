<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;

use App\User;

use App\Teknisi;

class TeknisiController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $teknisi = app('db')->select("
            SELECT * FROM user, teknisi 
            WHERE user.no_induk = teknisi.no_induk 
        ");
        return response()->json(['error'=>false, 'result'=>$teknisi]);    
    }
}