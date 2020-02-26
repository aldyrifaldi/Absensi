<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guru;
use Alert;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_guru' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $guru = Guru::create($request->all());

        if ($guru) {
            Alert::success('Berhasil','Data guru telah disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Data guru gagal disimpan');
        return redirect()->back();
    }

    public function update(Request $request,$guru)
    {
        $validator = Validator::make($request->all(),[
            'nama_guru' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal','Isi form dengan benar!');
            return redirect()->back()->withErrors($validator);
        }

        $guru = Guru::find($guru);
        if ($guru->update($request->all())) {
            Alert::success('Berhasil','Perubahan berhasil disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Perubahan gagal disimpan');
        return redirect()->back();
    }

    public function destroy($guru)
    {
        $guru = Guru::find($guru);
        if ($guru->delete()) {
            Alert::success('Berhasil','Data guru telah terhapus');
            return redirect()->back();
        }
        Alert::error('Gagal','Data guru tidak terhapus');
        return redirect()->back();
    }
}
