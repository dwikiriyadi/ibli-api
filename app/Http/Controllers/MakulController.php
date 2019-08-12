<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Makul;

class MakulController extends Controller
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
            'kode_makul' => 'required',
            'nama_makul' => 'required',
            'kode_prodi' => 'required'
        ]);

        $makul = new Makul;
        $makul->kode_makul = $request->kode_makul;
        $makul->nama_makul = $request->nama_makul;
        $makul->kode_prodi = $request->kode_prodi;
        $makul->save();
    }
    
    public function update(Request $request) {
        $this->validate($request, [
            'kode_makul' => 'required',
            'nama_makul' => 'required',
            'kode_prodi' => 'required'
        ]);

        $makul = Makul::where('kode_makul', $request->kode_makul)->update([
            'kode_makul' => $request->kode_makul,
            'nama_makul' => $request->nama_makul,
            'kode_prodi' => $request->kode_prodi,
        ]);
    }

    public function delete(Request $request) {
        $this->validate($request, [
            'kode_makul' => 'required'
        ]);

        $makul = Makul::where('kode_makul', $request->kode_makul)->delete();
    }
}
