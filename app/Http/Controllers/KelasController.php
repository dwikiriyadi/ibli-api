<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kelas;

class KelasController extends Controller
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
            'kode_kelas' => 'required',
            'kode_prodi' => 'required',
            'abjad_kelas' => 'required',
            'semester' => 'required'
        ]);

        $kelas = new Kelas;
        $kelas->kode_kelas = $request->kode_kelas;
        $kelas->kode_prodi = $request->kode_prodi;
        $kelas->abjad_kelas = $request->abjad_kelas;
        $kelas->semester = $request->semester;
        $kelas->save();
    }
    
    public function update(Request $request) {
        $this->validate($request, [
            'kode_kelas' => 'required',
            'kode_prodi' => 'required',
            'abjad_kelas' => 'required',
            'semester' => 'required'
        ]);

        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->update([
            'kode_kelas' => $request->kode_kelas,
            'kode_prodi' => $request->kode_prodi,
            'abjad_kelas' => $request->abjad_kelas,
            'semester' => $request->semester
        ]);
    }

    public function delete(Request $request) {
        $this->validate($request, [
            'kode_kelas' => 'required'
        ]);

        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->delete();
    }
}
