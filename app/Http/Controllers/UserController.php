<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\User;

use App\Mahasiswa;

use App\Dosen;

use App\Teknisi;

class UserController extends Controller {
    public function __construct(){
       $this->middleware('auth');
    }

    public function index(Request $request){
        $user = app('db')->select("SELECT * FROM 
        (
            SELECT user.no_induk, mahasiswa.nama_lengkap, user.email, user.role, user.admin FROM user, mahasiswa WHERE user.no_induk=mahasiswa.no_induk UNION
            SELECT user.no_induk, dosen.nama_lengkap, user.email, user.role, user.admin FROM user, dosen WHERE user.no_induk=dosen.no_induk UNION
            SELECT user.no_induk, teknisi.nama_lengkap, user.email, user.role, user.admin FROM user, teknisi WHERE user.no_induk=teknisi.no_induk 
        ) as user
        ");

        return response()->json(['error' => false, 'result' => $user]);        
    }

    public function tambah(Request $request) {
        $this->validate($request, [
            "no_induk" => "required",
            "nama_lengkap" => "required",
            "email" => "nullable",
            "password" => "required",
            "role" => "required",
            "admin" => "nullable",
            "foto" => "nullable"
        ]);

        if (!$this->checkAvailability($request->no_induk)){
            $user = new User;
            $user->no_induk =  $request->no_induk;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->admin = $request->admin;
            if ($request->role == 'Mahasiswa'){
                $this->validate($request, [
                    'kode_kelas' => "required"
                ]);
                $mahasiswa = new Mahasiswa;
                $mahasiswa->no_induk = $request->no_induk;
                $mahasiswa->nama_lengkap = $request->nama_lengkap;
                $mahasiswa->kode_kelas = $request->kode_kelas;
                $mahasiswa->foto = $request->foto;
                $mahasiswa->save();
            } else if ($request->role == 'Dosen'){
                $dosen = new Dosen;
                $dosen->no_induk = $request->no_induk;
                $dosen->nama_lengkap = $request->nama_lengkap;
                $dosen->foto = $request->foto;
                $dosen->save();
            } else if ($request->role == 'Teknisi'){
                $teknisi = new Teknisi;
                $teknisi->no_induk = $request->no_induk;
                $teknisi->nama_lengkap = $request->nama_lengkap;
                $teknisi->foto = $request->foto;
                $teknisi->save();
            }
            $user->save();
            return response()->json(['error' => false, 'status' => 'Pengguna berhasil ditambahkan']); 
        } else {
            return response()->json(['error' => true, 'status' => 'Pengguna ini sudah terdaftar']); 
        }
    }

    public function edit(Request $request) {
        return response()->json(['error' => false, 'result' => $this->getUserById($request->no_induk)]); 
    }

    public function cari(Request $request) {
        return response()->json(['error' => false, 'result' => $this->getUserByName($request->nama_lengkap)]); 
    }

    public function ubah(Request $request) {
        $this->validate($request, [
            "no_induk" => "required",
            "nama_lengkap" => "required",
            "email" => "nullable",
            "password" => "nullable",
            "role" => "required",
            "admin" => "nullable",
            "foto" => "nullable"
        ]);

        if ($this->checkAvailability($request->no_induk)){
            if ($request->role == 'Mahasiswa') {
                $this->validate($request, [
                    'kode_kelas' => "required"
                ]);
                $mahasiswa = Mahasiswa::where('no_induk', $request->no_induk)
                ->update([
                    'no_induk' => $request->no_induk,
                    'nama_lengkap' => $request->nama_lengkap,
                    'kode_kelas' => $request->kode_kelas,
                    'foto' => $request->foto
                ]);
            } else if ($request->role == 'Dosen') {
                $dosen = Dosen::where('no_induk', $request->no_induk)
                ->update([
                    'no_induk' => $request->no_induk,
                    'nama_lengkap' => $request->nama_lengkap,
                    'foto' => $request->foto
                ]);
            } else if ($request->role == 'Teknisi') {
                $teknisi = Teknisi::where('no_induk', $request->no_induk)
                ->update([
                    'no_induk' => $request->no_induk,
                    'nama_lengkap' => $request->nama_lengkap,
                    'foto' => $request->foto
                ]);
            }
            if ($request->password == ''){
                $user = User::where('no_induk', $request->no_induk)
                ->update([
                    'no_induk' => $request->no_induk,
                    'email' => $request->email,
                    'admin' => $request->admin
                ]);
            } else {
                $user = User::where('no_induk', $request->no_induk)
                ->update([
                    'no_induk' => $request->no_induk,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'admin' => $request->admin
                ]);
            }
            return response()->json(['error' => true, 'status' => 'Data pengguna berhasil diubah']);                         
        } else {
            return response()->json(['error' => true, 'status' => 'Pengguna ini belum terdaftar']);             
        }
    }

    public function hapus(Request $request) {
        $this->validate($request, [
            "no_induk" => "required"
        ]);

        $user = User::where('no_induk', $request->no_induk)->first();

        if ($user->role == 'Mahasiswa') {
            $mahasiswa = Mahasiswa::where('no_induk', $request->no_induk)->delete();
            $user->delete();
            return response()->json(['error' => false, "status" => "Pengguna berhasil dihapus"]);        
        } else if ($user->role == 'Dosen') {
            $dosen = Dosen::where('no_induk', $request->no_induk)->delete();
            $user->delete();
            return response()->json(['error' => false, "status" => "Pengguna berhasil dihapus"]); 
        } else if ($user->role == 'Teknisi') {
            $teknisi = Teknisi::where('no_induk', $request->no_induk)->delete();
            $user->delete();
            return response()->json(['error' => false, "status" => "Pengguna berhasil dihapus"]); 
        } else {
            return response()->json(['error' => true, "status" => "Pengguna tidak ditemukan"]);        
        }
    }

    public function profil(Request $request){
        return response()->json(['error' => false, 'result' => $this->getUserByToken($request->api_key)]); 
    }

    public function gantiPassword(Request $request){
        $this->validate($request, [
            'api_key' => 'required',
            'password_lama' => 'required',
            'password_baru' => 'required'
        ]);
        
        $user = User::where('api_key', $request->api_key)->first();

        if(Hash::check($request->password_lama, $user->password)){
            User::where('no_induk', $user->no_induk)
            ->update(['password' => Hash::make($request->password_baru)]);
            return response()->json(['error' => false, 'status' => 'Password berhasil diubah, silahkan login kembali']);
        } else {
            return response()->json(['error' => true, 'status' => 'Password gagal diubah']);
        }
    }

    private function getUserByToken($token){
        $profil = app('db')->select("SELECT * FROM 
        (
            SELECT user.no_induk, mahasiswa.nama_lengkap, user.email, user.role, user.admin, user.api_key FROM user, mahasiswa WHERE user.no_induk=mahasiswa.no_induk UNION
            SELECT user.no_induk, dosen.nama_lengkap, user.email, user.role, user.admin, user.api_key FROM user, dosen WHERE user.no_induk=dosen.no_induk UNION
            SELECT user.no_induk, teknisi.nama_lengkap, user.email, user.role, user.admin, user.api_key FROM user, teknisi WHERE user.no_induk=teknisi.no_induk 
        ) as user WHERE user.api_key=?
        ", [$token]);
        return $profil;
    }

    private function getUserById($id){
        $editable = app('db')->select("SELECT * FROM 
        (
            SELECT user.no_induk, mahasiswa.nama_lengkap, user.email, user.role, user.admin, mahasiswa.foto, mahasiswa.kode_kelas FROM user, mahasiswa WHERE user.no_induk=mahasiswa.no_induk UNION
            SELECT user.no_induk, dosen.nama_lengkap, user.email, user.role, user.admin, dosen.foto, NULL as kode_kelas FROM user, dosen WHERE user.no_induk=dosen.no_induk UNION
            SELECT user.no_induk, teknisi.nama_lengkap, user.email, user.role, user.admin, teknisi.foto, NULL as kode_kelas FROM user, teknisi WHERE user.no_induk=teknisi.no_induk 
        ) as user WHERE user.no_induk=?
        ", [$id]);
        return $editable;
    }

    private function getUserByName($nama){
        $find = app('db')->select("SELECT * FROM 
        (
            SELECT user.no_induk, mahasiswa.nama_lengkap, user.email, user.role, user.admin, mahasiswa.foto, mahasiswa.kode_kelas FROM user, mahasiswa WHERE user.no_induk=mahasiswa.no_induk UNION
            SELECT user.no_induk, dosen.nama_lengkap, user.email, user.role, user.admin, dosen.foto, NULL as kode_kelas FROM user, dosen WHERE user.no_induk=dosen.no_induk UNION
            SELECT user.no_induk, teknisi.nama_lengkap, user.email, user.role, user.admin, teknisi.foto, NULL as kode_kelas FROM user, teknisi WHERE user.no_induk=teknisi.no_induk 
        ) as user WHERE user.nama_lengkap LIKE '?%'
        ", [$nama]);
        return $find;
    }

    private function checkAvailability($no_induk) {
        if (User::where('no_induk', $no_induk)->count() === 1) {
            return true;
        } else {
            return false;
        }
    }
}