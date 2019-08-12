<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Barang;


class BarangController extends Controller
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

    public function  index(Request $request){
        $barang = app('db')->select("SELECT * FROM barang");
        return response()->json(['result' => $barang]);
    }

    public function tambah(Request $request) {
        $this->validate($request, [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'kondisi' => 'required',
        ]);
        if (!$this->hasData($request->kode_barang)){
            $barang = new Barang;
            $barang->kode_barang = $request->kode_barang;
            $barang->nama_barang = $request->nama_barang;
            $barang->jenis_barang = $request->jenis_barang;
            $barang->kondisi =  $request->kondisi;
            $barang->save();
            return response()->json(['status' => 'Data Barang berhasil ditambah']);
        } else {
            return response()->json(['status' => 'Data Barang sudah ada']);
        }
    }
    
    public function ubah(Request $request) {
        $this->validate($request, [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'kondisi' => 'required',
        ]);
        if ($this->hasData($request->kode_barang)){
            $barang = Barang::where('kode_barang', $request->kode_barang)->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'jenis_barang' => $request->jenis_barang,
                'kondisi' => $request->kondisi,
                'status_peminjaman' => $request->status_peminjaman
            ]);
            return response()->json(['status' => 'Data Barang berhasil diedit']);
        } else {
            return response()->json(['status' => 'Data Barang tidak ditemukan']);
        }
    }

    public function hapus(Request $request) {
        $this->validate($request, [
            'kode_barang' => 'required'
        ]);
        if ($this->hasData($request->kode_barang)){
            $barang = Barang::where('kode_barang', $request->kode_barang)->delete();
            return response()->json(['status' => 'Data Barang berhasil dihapus']);
        } else {
            return response()->json(['status' => 'Data Barang tidak ditemukan']);
        }
    }

    public function edit(Request $request) {
        $barang = app('db')->select("SELECT * FROM barang WHERE kode_barang=?",[$request->kode_barang]);
        return response()->json(['result' => $barang]);
    }

    public function report(Request $request) {

    }

    public function search(Request $request) {
        
    } 

    private function hasData($id){
        if (Barang::where('kode_barang', $id)->count() === 1){
            return true;
        } else {
            return false;
        }
    }
}
