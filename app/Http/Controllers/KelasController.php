<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Alert;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $kelas = Kelas::create($request->all());

        if ($kelas) {
            Alert::success('Berhasil','Data kelas telah disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Data kelas gagal disimpan');
        return redirect()->back();
    }

    public function update(Request $request,$kelas)
    {
        $validator = Validator::make($request->all(),[
            'nama_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal','Isi form dengan benar!');
            return redirect()->back()->withErrors($validator);
        }

        $kelas = Kelas::find($kelas);
        if ($kelas->update($request->all())) {
            Alert::success('Berhasil','Perubahan berhasil disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Perubahan gagal disimpan');
        return redirect()->back();
    }

    public function destroy($kelas)
    {
        $kelas = Kelas::find($kelas);
        if ($kelas->delete()) {
            Alert::success('Berhasil','Data kelas telah terhapus');
            return redirect()->back();
        }
        Alert::error('Gagal','Data kelas tidak terhapus');
        return redirect()->back();
    }
}
