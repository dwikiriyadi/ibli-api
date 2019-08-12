<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;

use App\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('no_induk', $request->username)->first();

        if(Hash::check($request->password, $user->password)){
            $api_key = base64_encode(str_random(40));
            User::where('no_induk', $request->username)->update(['api_key' => $api_key]);
            return response()->json(['error' => false, 'status' => 'berhasil masuk', 'api_key' => $api_key, 'admin' => $user->admin, 'role' => $user->role]);
        } else {
            return response()->json(['error' => true, 'status' => 'Gagal masuk']);
        }  
    }
}   


