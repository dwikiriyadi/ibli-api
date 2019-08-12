<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ruang;

class RuangController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function store(Request $request) {
        $this->validate($request, [
            'kode_ruang' => 'required',
            'nama_ruang' => 'required',
        ]);

        $ruang = new Ruang;
        $ruang->kode_ruang = $request->kode_ruang;
        $ruang->nama_ruang = $request->nama_ruang;
        $ruang->save();
    }
    
    public function update(Request $request) {
        $this->validate($request, [
            'kode_ruang' => 'required',
            'nama_ruang' => 'required',
        ]);

        $ruang = Ruang::where('kode_ruang', $request->kode_ruang)->update([
            'kode_ruang' => $request->kode_ruang,
            'nama_ruang' => $request->nama_ruang,
        ]);
    }

    public function delete(Request $request) {
        $this->validate($request, [
            'kode_ruang' => 'required'
        ]);

        $ruang = Ruang::where('kode_ruang', $request->kode_ruang)->delete();
    }
}
