<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalAbsensi;
use App\Kelas;
use App\DetailAbsensi;
use App\Absen;
use App\Santri;
use Illuminate\Support\Str;
use Carbon\Carbon;
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

            if (count($explode[$value->nama_kelas]) != 0) {
                foreach ($explode[$value->nama_kelas] as $k => $example) {
                    $hasil[$value->nama_kelas][$example] = $example;
                }
            }
            else {
                $hasil = [];
            }
            array_push($array,[
                'nama_kelas' => $value->nama_kelas,
                'id_kelas' => $value->id_kelas,
                'id_jadwal' => $value->id_jadwal,
                'nama_hari' => $hasil[$value->nama_kelas]
            ]);
        }


        return response()->json($array);
    }

    public function dataAbsenSantri($kelas, $tanggal)
    {
        $detailabsen = DetailAbsensi::where('tanggal_absensi',$tanggal)
                            ->where('id_kelas',$kelas)
                            ->first();

        $absen = Santri::leftJoin('absensi',function($query) use($detailabsen) {
            $query->on('santri.id','=','absensi.id_santri')
            ->where('absensi.no_detail_absensi',$detailabsen->no_detail_absensi);
        })
        ->where('santri.id_kelas',$kelas)
        ->select('*','santri.id as id_santri','absensi.id as id_absensi','absensi.no_detail_absensi as no_detail_absensi','absensi.alasan')
        ->get();

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

    public function dataAbsensi($kelas)
    {
            $santri = Santri::leftJoin('absensi',function($query){
                $query->on('santri.id','=','absensi.id_santri');
            })->leftJoin('detail_absensi',function($query) use($kelas){
                $query->on('detail_absensi.no_detail_absensi','=','absensi.no_detail_absensi')
                ->where('detail_absensi.id_kelas',$kelas);
            })
            ->get();


            $detailabsen = DetailAbsensi::where('id_kelas',$kelas)
                                        ->whereYear('created_at',date('Y'))->get();
            foreach ($detailabsen as $key => $value) {
                $array[$value->tanggal_absensi] = Santri::leftJoin('absensi',function($query) use($value){
                    $query->on('absensi.id_santri','=','santri.id')
                    ->where('absensi.no_detail_absensi',$value->no_detail_absensi);
                })
                ->select('santri.id as id','nama_santri','santri.created_at as created_at_santri','absensi.status','absensi.no_detail_absensi','absensi.created_at as created_at_absensi','absensi.alasan')
                ->orderBy('santri.nama_santri','asc')
                ->get();
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