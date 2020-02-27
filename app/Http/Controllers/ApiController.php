<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalAbsensi;
use App\Kelas;
use App\DetailAbsensi;

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
        $no = 0;
        $finish = [];
        foreach ($kelas as $key => $value) {
            $explode = explode(',',$value->nama_hari);
            $akhir = [];
            foreach ($explode as $k => $example) {
                $hasil[$example] = $example;
            }
            array_push($finish,[$hasil]);
            array_push($array,[
                'nama_kelas' => $value->nama_kelas,
                'id_kelas' => $value->id_kelas,
                'id_jadwal' => $value->id_jadwal,
                'nama_hari' => $finish[$key],
            ]);
        }


        return response()->json($array);
    }

    public function jadwalAbsensiPerKelas($kelas)
    {
        $jadwal = DetailAbsensi::where('id_kelas',$kelas)->get();
        $array = [];
        foreach ($jadwal as $key => $value) {
            array_push($array,[
                'string_tanggal' => date('F, d M Y',strtotime($value->tanggal_absensi)),
                'format_date' => $value->tanggal_absensi
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


    public function kelas(){
        $kelas = Kelas::get();
        return response()->json($kelas);
    }
}