<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Santri;
use Alert;
use Illuminate\Support\Facades\Validator;

class SantriController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_santri' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $santri = Santri::create($request->all());

        if ($santri) {
            Alert::success('Berhasil','Data santri telah disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Data santri gagal disimpan');
        return redirect()->back();
    }

    public function update(Request $request,$santri)
    {
        $validator = Validator::make($request->all(),[
            'nama_santri' => 'required',
            'alamat' => 'required',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal','Isi form dengan benar!');
            return redirect()->back()->withErrors($validator);
        }

        $santri = Santri::find($santri);
        if ($santri->update($request->all())) {
            Alert::success('Berhasil','Perubahan berhasil disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Perubahan gagal disimpan');
        return redirect()->back();
    }

    public function destroy($santri)
    {
        $santri = Santri::find($santri);
        if ($santri->delete()) {
            Alert::success('Berhasil','Data santri telah terhapus');
            return redirect()->back();
        }
        Alert::error('Gagal','Data santri tidak terhapus');
        return redirect()->back();
    }
}
