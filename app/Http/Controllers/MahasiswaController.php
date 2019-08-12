<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;

use App\User;

use App\Mahasiswa;

class MahasiswaController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        if ($request->prodi == 'none'){
            $mahasiswa = app('db')->select("
                SELECT * FROM user, mahasiswa, kelas, prodi 
                WHERE user.no_induk = mahasiswa.no_induk AND kelas.kode_kelas=mahasiswa.kode_kelas AND kelas.kode_prodi=prodi.kode_prodi  
            ");
            return response()->json(['error'=>false, 'result'=>$mahasiswa]);
        } else if ($request->prodi == 'Teknik Listrik'){
            $mahasiswa = $this->getMahasiswaByProdi($request->prodi);
            return response()->json(['error'=>false, 'result'=>$mahasiswa]);
        } else if ($request->prodi == 'Teknik Elektronika'){
            return response()->json(['error'=>false, 'result'=>$this->getMahasiswaByProdi($request->prodi)]);
        } else if ($request->prodi == 'Teknik Informatika'){
            return response()->json(['error'=>false, 'result'=>$this->getMahasiswaByProdi($request->prodi)]);
        }
        
        
    }
    private function getMahasiswaByProdi($prodi){
        $mahasiswa = app('db')->select("
            SELECT * FROM user, mahasiswa, kelas, prodi 
            WHERE user.no_induk = mahasiswa.no_induk AND kelas.kode_kelas=mahasiswa.kode_kelas AND kelas.kode_prodi=prodi.kode_prodi  
            AND prodi.nama_prodi = ?  
        ", [$prodi]);
        return $mahasiswa;
    }
}