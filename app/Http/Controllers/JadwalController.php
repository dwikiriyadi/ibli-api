<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jadwal;

class JadwalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $barang = app('db')->select("SELECT * FROM jadwal");
        return response()->json(['result' => $barang]);
    }

    public function tambah(Request $request) {
        $this->validate($request, [
            "kode_makul" => "required",
            "no_induk" => "required",
            "kode_kelas" => "required",
            "kode_ruang" => "required",
            "hari" => "required",
            "jam_masuk" => "required",
            "jam_keluar" => "required"
        ]);

        $kode_jadwal =  substr($request->hari, 0, 3) . $request->kode_makul . $request->no_induk . $request->jam_masuk;

        if (!$this->hasData($kode_jadwal)){
            $jadwal = new Jadwal;
            $jadwal->kode_jadwal = $kode_jadwal;
            $jadwal->kode_makul = $request->kode_makul;
            $jadwal->no_induk = $request->no_induk;
            $jadwal->kode_kelas = $request->kode_kelas;
            $jadwal->kode_ruang = $request->kode_ruang;
            $jadwal->hari = $request->hari;
            $jadwal->jam_masuk = $request->jam_masuk;
            $jadwal->jam_keluar = $request->jam_keluar;
            $jadwal->save();
            return response()->json(["error" => true,"status" => "Data jadwal berhasil ditambah"]);
        } else {
            return response()->json(["error" => true,"status" => "Data jadwal sudah terdaftar"]);
        }
    }

    public function ubah(Request $request) {
        $this->validate($request, [
            "kode_jadwal" => "required", 
            "kode_makul" => "required",
            "no_induk" => "required",
            "kode_kelas" => "required",
            "kode_ruang" => "required",
            "hari" => "required",
            "jam_masuk" => "required",
            "jam_keluar" => "required"
        ]); 
        if ($this->hasData($request->kode_jadwal)){
            $jadwal = Jadwal::where('kode_jadwal', $request_kode_jadwal)->update([
                'kode_jadwal' => $request->kode_jadwal,
                'kode_makul' => $request->kode_makul,
                'no_induk' => $request
            ]);
            return response()->json(["error" => true,"status" => "Data jadwal berhasil diubah"]);
        } else {
            return response()->json(["error" => true,"status" => "Data jadwal tidak ditemukan"]);            
        }
    }

    public function hapus(Request $request) {
        $this->validate([
            "kode_jadwal" => "required"
        ]);
        
        if ($this->hasData($request->kode_jadwal)) {
            return response()->json(["error" => false,"status" => "Data jadwal berhasil dihapus"]);
        } else {
            
            return response()->json(["error" => true,"status" => "Data jadwal tidak ditemukan"]);
        }
    }

    public function edit(Request $request) {

    }

    private function hasData($id){
        if (Jadwal::where('kode_jadwal', $id)->count() === 1){
            return true;
        } else {
            return false;
        }
    }
}