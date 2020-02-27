<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetailAbsensi;
use Illuminate\Support\Str;

class DetailAbsensiController extends Controller
{
    public function store(Request $request)
    {
        $cek_detail_absen = DetailAbsensi::where('id_kelas',$request->id_kelas)
                                        ->where('tanggal_absensi',date('Y-m-d'))->count();
        if ($cek_detail_absen > 0) {
            return response()->json(['Data sudah ada']);
        }
        $no_detail = json_encode(Str::random(8));
        $detail_absen = DetailAbsensi::create([
            'no_detail_absensi' => $no_detail,
            'tanggal_absensi' => date('Y-m-d'),
            'id_kelas' => $request->id_kelas,
        ]);

        if ($detail_absen) {
            return response()->json(['Berhasil']);
        }
        return response()->json(['Gagal']);
    }
}
