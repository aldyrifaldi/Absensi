<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalAbsensi;
use Alert;
use Illuminate\Support\Facades\Validator;

class JadwalAbsensiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_hari' => 'required',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $jadwal = JadwalAbsensi::create($request->all());

        if ($jadwal) {
            Alert::success('Berhasil','Jadwal absensi telah disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Jadwal absensi gagal disimpan');
        return redirect()->back();
    }

    public function update(Request $request,$jadwal)
    {
        $validator = Validator::make($request->all(),[
            'nama_hari' => 'required',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal','Isi form dengan benar!');
            return redirect()->back()->withErrors($validator);
        }

        $jadwal = JadwalAbsensi::find($jadwal);
        if ($jadwal->update($request->all())) {
            Alert::success('Berhasil','Perubahan berhasil disimpan');
            return redirect()->back();
        }
        Alert::success('Gagal','Perubahan gagal disimpan');
        return redirect()->back();
    }

    public function destroy($jadwal)
    {
        $jadwal = JadwalAbsensi::find($jadwal);
        if ($jadwal->delete()) {
            Alert::success('Berhasil','Jadwal absensi telah terhapus');
            return redirect()->back();
        }
        Alert::error('Gagal','Jadwal absensi tidak terhapus');
        return redirect()->back();
    }
}
