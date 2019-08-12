<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Prodi;

class ProdiController extends Controller
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
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
        ]);

        $prodi = new Prodi;
        $prodi->kode_prodi = $request->kode_prodi;
        $prodi->nama_prodi = $request->nama_prodi;
        $prodi->save();
    }
    
    public function update(Request $request) {
        $this->validate($request, [
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
        ]);

        $prodi = Prodi::where('kode_prodi', $request->kode_prodi)->update([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
        ]);
    }

    public function delete(Request $request) {
        $this->validate($request, [
            'kode_prodi' => 'required'
        ]);

        $prodi = Prodi::where('kode_prodi', $request->kode_prodi)->delete();
    }
}
