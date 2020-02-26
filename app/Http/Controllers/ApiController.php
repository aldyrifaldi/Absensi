<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalAbsensi;
use App\Kelas;

class ApiController extends Controller
{
    public function inputJadwal(Request $request)
    {
        $hari = implode(',',$request->hari);

        $jadwal = JadwalAbsensi::where('id_kelas',$request->kelas);
        if ($jadwal->count() > 0) {
            $jadwal->update([
                'nama_hari' => $hari,
            ]);
        }
        else {
            $jadwal = JadwalAbsensi::create([
                'nama_hari' => $hari,
                'id_kelas' => $request->kelas,
            ]);
        }
        
        if ($jadwal) {
            return response()->json(['Berhasil' => 'Jadwal berhasil ditambahkan']);
        }
        return response()->json('Gagal','Jadwal gagal ditambahkan');
    }

    public function jadwalAbsensi()
    {
        $kelas = Kelas::leftJoin('jadwal_absensi','jadwal_absensi.id_kelas','=','kelas.id')->select('*','jadwal_absensi.id as id_jadwal','kelas.id as id_kelas')->get();
        $array = [];

        foreach ($kelas as $key => $value) {
            $explode = explode(',',$value->nama_hari);
            foreach ($explode as $k => $example) {
                $nama_hari[$example] = $example; 
            }
            array_push($array,[
                'nama_kelas' => $value->nama_kelas,
                'id_kelas' => $value->id_kelas,
                'id_jadwal' => $value->id_jadwal,
                'nama_hari' => $nama_hari,
            ]);
        }


        return response()->json($array);
    }

    public function absensi(Request $request)
    {
        $no_detail = time().Str::random(8);
        $absensi = DetailAbsen::create([
            'no_detail_absensi' => $request->no_detail,
            'tanggal_absensi' => date('Y-m-d'),
        ]);

        if ($absensi) {
            return response()->json('Berhasil','Absensi Terbuka');
        }
        return response()->json('Gagal','Absensi Tidak Terbuka');
    }
}