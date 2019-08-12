<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Peminjaman;

use App\Barang;

use App\User;

use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request) {
        $peminjaman = app('db')->select("SELECT * FROM peminjaman, mahasiswa, barang WHERE peminjaman.no_induk=mahasiswa.no_induk AND peminjaman.kode_barang=barang.kode_barang");
        return response()->json(['error' => false, 'result' => $peminjaman]);
    }

    public function tambah(Request $request) {
        $this->validate($request,[
            "no_induk" => "required",
            "kode_barang" => "required"
        ]);

        if ($this->cekKondisiBarang($request->kode_barang)){
            if ($this->cekStatusPeminjaman($request->kode_barang)){
                $tgl_pinjam = Carbon::now('Asia/Jakarta')->toDateString();
                $jam_pinjam = Carbon::now('Asia/Jakarta')->toTimeString();
                $kode_peminjaman = $request->no_induk . $request->kode_barang . $tgl_pinjam . $jam_pinjam;
                $pinjam = new Peminjaman;
                $pinjam->kode_peminjaman = $kode_peminjaman;
                $pinjam->no_induk = $request->no_induk;
                $pinjam->kode_barang = $request->kode_barang;
                $pinjam->tgl_pinjam = $tgl_pinjam;
                $pinjam->jam_pinjam = $jam_pinjam;
                $pinjam->save();
                
                $barang = Barang::where('kode_barang', $request->kode_barang)->update([
                    'status_peminjaman' => 'Dipinjam'
                ]);
                return response()->json(['error' => false, 'status' => 'Barang berhasil dipinjam']);
            } else {
                return response()->json(['error' => true, 'status' => 'Barang sudah dipinjam']);
            }
        } else {
            return response()->json(['error' => true, 'status' => 'Barang tidak dapat dipinjam']);
        }        
    }

    public function ubah(Request $request) {
        $this->validate($request,[
            "no_induk" => "required",
            "kode_barang" => "required"
        ]);
        if (!$this->cekStatusPeminjaman($request->kode_barang)){
            $tgl_kembali = Carbon::now('Asia/Jakarta')->toDateString();
            $jam_kembali = Carbon::now('Asia/Jakarta')->toTimeString();
            if (Peminjaman::where('no_induk',$request->no_induk)
            ->where('kode_barang', $request->kode_barang)->where('tgl_kembali', '')->count() === 1) {
                $kembali = Peminjaman::where('no_induk',$request->no_induk)
                ->where('kode_barang', $request->kode_barang)->where('tgl_kembali', '')
                ->update([
                    'tgl_kembali' => $tgl_kembali,
                    'jam_kembali' => $jam_kembali
                ]);

                $barang = Barang::where('kode_barang', $request->kode_barang)->update([
                    'status_peminjaman' => 'Tidak Dipinjam'
                ]);
                return response()->json(['error' => false, 'status' => 'Barang sudah dikembalikan']);
            } else {
                return response()->json(['error' => true, 'status' => 'Anda bukan Peminjam Barang ini']);
            }            
        } else {
            return response()->json(['error' => true, 'status' => 'Anda tidak melakukan peminjaman barang ini']);
        }
    }

    public function hapus(Request $request) {
        $peminjaman = Peminjaman::where('kode_peminjaman', $request->kode_peminjaman)->delete();
        return response()->json(['error' => false, 'status' => 'Data peminjaman berhasil dihapus']);
    }

    public function edit(Request $request) {
        $peminjaman = app('db')->select("SELECT * FROM peminjaman, mahasiswa, barang WHERE peminjaman.no_induk=mahasiswa.no_induk AND peminjaman.kode_barang=barang.kode_barang AND peminjaman.kode_peminjaman=?",[$request->kode_peminjaman]);
        return response()->json(['error' => false, 'result' => $peminjaman]);
    }

    private function cekKondisiBarang($id) {
        if (Barang::where('kode_barang', $id)->first()->kondisi == "Baik"){
            return true;
        } else {
            return false;
        }
    }

    private function cekStatusPeminjaman($id) {
        if (Barang::where('kode_barang', $id)->first()->status_peminjaman == "Tidak Dipinjam"){
            return true;
        } else {
            return false;
        }
    }
}