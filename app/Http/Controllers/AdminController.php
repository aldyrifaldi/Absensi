<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Guru;
use App\Santri;
use App\Kelas;
use App\Absen;
use App\DetailAbsensi;
use App\JadwalAbsensi;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function pages($pages)
    {
        if (!Auth::user()) {
            return redirect('/');
        }
        if (\View::exists('adminty.pages.'.$pages))
        {
            $parameter = [
                'dashboard' => [
                    'pages' => $pages,
                ],
                'data-kelas' => [
                    'pages' => $pages,
                    'data' => Kelas::get(),
                ],
                'data-guru' => [
                    'pages' => $pages,
                    'data' => Guru::get(),
                ],
                'data-santri' => [
                    'pages' => $pages,
                    'data' => Santri::join('kelas','kelas.id','=','santri.id_kelas')->select('*','santri.id as id_santri')->get(),
                    'kelas' => Kelas::get(),
                ],
                'absen-santri' => [
                    'pages' => $pages,
                    'data' => Santri::join('kelas','kelas.id','=','santri.id_kelas')->select('*','santri.id as id_santri')->get(),
                    'kelas' => Kelas::get(),
                    'tanggal' => DetailAbsensi::get(),
                ],
                'jadwal-absensi' => [
                    'pages' => $pages,
                    'data' => Kelas::leftJoin('jadwal_absensi','jadwal_absensi.id_kelas','=','kelas.id')->select('*','jadwal_absensi.id as id_jadwal','kelas.id as id_kelas')->get(),
                ],
                'pengaturan-absensi' => [
                    'pages' => $pages,
                ],
            ];
            
            $data = [];

            foreach ($parameter[$pages] as $key => $value) {
                $data[$key] = $value;
            }

            return view('adminty.pages.'.$pages,$data);
        }
        Alert::error('Halaman tidak tersedia');
        return redirect()->back();
    }
}
