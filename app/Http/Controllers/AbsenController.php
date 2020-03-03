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

        $cek_status = Absen::where('id_santri',$request->id_santri)
                            ->where('no_detail_absensi',$request->no_detail_absensi)
                            ->first();

        if ($cek_status) {
            $cek_status->update([
                'status' => $request->status,
            ]);

            $cek_status->delete();

            if ($request->status == 'Hadir') {
                return response()->json(['Santri telah hadir']);
            }

            return response()->json(['Berhasil diupdate']);
        }

        if ($request->status == 'Hadir') {
            return response()->json(['Santri telah hadir']);
        }
        
        $absen = Absen::create($request->all());
        if ($absen) {
            return response()->json(['Berhasil' => 'Absensi berhasil terkirim']);
        }
        return response()->json(['Gagal' => 'Absensi gagal terkirim']);
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
