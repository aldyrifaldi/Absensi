<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalAbsensi;
use App\Kelas;
use App\DetailAbsensi;
use App\Absen;
use App\Santri;
use Illuminate\Support\Str;

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
            $explode[$value->nama_kelas] = explode(',',$value->nama_hari);
            $akhir = [];

            if (count($explode[$value->nama_kelas]) > 1) {
                foreach ($explode[$value->nama_kelas] as $k => $example) {
                    $hasil[$example] = $example;
                }
            }
            else {
                $hasil = [];
            }
            array_push($array,[
                'nama_kelas' => $value->nama_kelas,
                'id_kelas' => $value->id_kelas,
                'id_jadwal' => $value->id_jadwal,
                'nama_hari' => $hasil
            ]);
        }


        return response()->json($array);
    }

    public function dataAbsenSantri($kelas, $tanggal)
    {
        $detailabsen = DetailAbsensi::where('tanggal_absensi',$tanggal)
                            ->where('id_kelas',$kelas)
                            ->first();

        $absen = Santri::leftJoin('absensi','santri.id','=','absensi.id_santri',function($query){
            $query->where('no_detail_absensi',$detailabsen->no_detail_absensi);
        })->where('santri.id_kelas',$kelas)->select('*','santri.id as id_santri','absensi.id as id_absensi','absensi.no_detail_absensi as no_detail_absensi','absensi.alasan')->get();

        $array = [];
        foreach ($absen as $key => $value) {
            array_push($array,[
                'nama_santri' => $value->nama_santri,
                'no_detail_absensi' => $detailabsen->no_detail_absensi,
                'status' => $value->status,
                'alamat' => $value->alamat,
                'id_santri' => $value->id_santri,
                'alasan' => $value->alasan,
            ]);
        }
        return response()->json($array);
    }


    public function alasanSantri(Request $request)
    {
        $absen = Absen::where('id_santri',$request->id_santri)
                        ->where('no_detail_absensi',$request->no_detail_absensi)
                        ->first();
        
        if ($absen->update(['alasan' => $request->alasan])) {
            return response()->json(['Berhasil']);
        }
        return response()->json(['Gagal']);
    }

    public function jadwalAbsensiPerKelas($kelas)
    {
        
        $jadwal = DetailAbsensi::where('id_kelas',$kelas)->get();
        $array = [];
        foreach ($jadwal as $key => $value) {
            array_push($array,[
                'string_tanggal' => date('l, d M Y',strtotime($value->tanggal_absensi)),
                'format_date' => $value->tanggal_absensi
            ]);
        }
        return response()->json($array);
    }

    public function kelas(){
        $kelas = Kelas::get();
        return response()->json($kelas);
    }
}