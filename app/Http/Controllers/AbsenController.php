<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absen;
use Alert;
use Illuminate\Support\Facades\Validator;

class AbsenController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_santri' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        $absen = Absen::create($request->all());
        if ($absen) {
            return response()->json(['Berhasil' => 'Absensi berhasil terkirim']);
        }
        return response()->json(['Gagal' => 'Absensi gagal terkirim']);
    }

    public function update(Request $request,$absen)
    {
        $validator = Validator::make($request->all(),[
            'id_santri' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        $absen = Absen::find($absen)->update($request->all());
        if ($absen) {
            return response()->json(['Berhasil' => 'Absensi berhasil diupdate']);
        }
        return response()->json(['Gagal' => 'Absensi gagal diupdate']);
    }

    public function destroy($absen)
    {
        $absen = Absen::find($absen);

        if ($absen) {
            return response()->json(['Berhasil' => 'Absensi berhasil terhapus']);
        }
        return response()->json(['Gagal' => 'Absensi gagal terhapus']);
    }
}
