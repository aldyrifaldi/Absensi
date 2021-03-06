<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalAbsensi;
use App\Kelas;
use App\DetailAbsensi;
use App\PengaturanAbsensi;
use App\Absen;
use App\Kegiatan;
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
            $tanggal_mulai = PengaturanAbsensi::select('tanggal_mulai')->where('id_kelas',$value->id_kelas)->first();
            $kegiatan = Kegiatan::select('tanggal_mulai','tanggal_berakhir','kegiatan')->where('id_kelas',$value->id_kelas)->get();
            if (count($explode[$value->nama_kelas]) != 0) {
                foreach ($explode[$value->nama_kelas] as $k => $example) {
                    $hasil[$value->nama_kelas][$example] = $example;
                    $daftar_hari[$value->nama_kelas][$k] = $example;
                }
            }
            else {
                $hasil = [];
            }
            array_push($array,[
                'nama_kelas' => $value->nama_kelas,
                'id_kelas' => $value->id_kelas,
                'id_jadwal' => $value->id_jadwal,
                'nama_hari' => $hasil[$value->nama_kelas],
                'daftar_hari' => $daftar_hari[$value->nama_kelas],
                'tanggal_mulai' => isset($tanggal_mulai->tanggal_mulai) ? $tanggal_mulai->tanggal_mulai : null,
                'kegiatan' => $kegiatan,
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

    public function dataAbsensi($kelas,$tahun,$bulan)
    {          
            $santri = Santri::where('id_kelas',$kelas)
                            ->get();
            $array = [];
            $jadwal_absensi = JadwalAbsensi::where('id_kelas',$kelas)
                                        ->first();

            foreach ($santri as $key => $value) {
                $detailabsen = DetailAbsensi::where('id_kelas',$kelas)
                                            ->whereYear('created_at',$tahun)
                                            ->whereMonth('created_at',$bulan)
                                            ->orderBy('tanggal_absensi','asc')
                                            ->get();
                $string_tanggal = '';
                foreach ($detailabsen as $k => $v) {
                    $absen = Absen::where('id_santri',$value->id)
                                    ->where('absensi.no_detail_absensi',$v->no_detail_absensi)
                                    ->select('absensi.status','absensi.alasan','detail_absensi.tanggal_absensi')
                                    ->join('detail_absensi','detail_absensi.no_detail_absensi','=','absensi.no_detail_absensi')
                                    ->get();
                    $string_tanggal .= $v->tanggal_absensi.',';
                    $array_absen[date('d F Y',strtotime($v->tanggal_absensi))] = $absen;
                    $array_tanggal_absensi[$k] = date('d/m',strtotime($v->tanggal_absensi));
                }
                
                array_push($array,[
                    'id' => $value->id,
                    'nama_santri' => $value->nama_santri,
                    'status' => isset($array_absen) ? $array_absen : null,
                    'tanggal_absensi' => $string_tanggal,
                ]);
            }

            $jadwal_absensi = explode(',',$jadwal_absensi->nama_hari);
            
            foreach ($jadwal_absensi as $j => $s) {
                $array_detail[$j] = $s;
            }

        return response()->json([
            'data' => $array,
            'jadwal' => $array_detail,
            'tanggal_absensi' => isset($array_tanggal_absensi) ? $array_tanggal_absensi : null,
        ]);
    }


    public function tahunAbsensi($kelas) 
    {
        $detailabsen = DetailAbsensi::where('id_kelas',$kelas)
                                    ->orderBy('tanggal_absensi','asc')
                                    ->get();

        foreach ($detailabsen as $key => $value) {
            $array_tahun_detail_absensi[$key] = date('Y-m-d',strtotime($value->created_at));
        }

        return response()->json($array_tahun_detail_absensi);
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