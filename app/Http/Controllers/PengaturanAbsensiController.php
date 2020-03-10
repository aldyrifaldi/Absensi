<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PengaturanAbsensi;
use Illuminate\Support\Facades\Validator;

class PengaturanAbsensiController extends Controller
{

    public function index() 
    {
        $pengaturan = PengaturanAbsensi::select('*','pengaturan_absensi.id as id','kelas.id as id_kelas')->join('kelas','kelas.id','=','pengaturan_absensi.id_kelas')->get();
        $no = 1;
        foreach ($pengaturan as $key => $value) {
            $menu = '   
                        <div class="btn-group">
                            <button type="button" data-toggle="modal" class="btn btn-warning btn-sm" onclick="editMulai('.$value->id.','.date('Y',strtotime($value->tanggal_mulai)).','.date('m',strtotime($value->tanggal_mulai)).','.date('d',strtotime($value->tanggal_mulai)).')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button type="button" data-toggle="modal" onclick="hapusMulai('.$value->id.')" class="btn btn-sm btn-danger" data-target="#hapus'.$value->id.'."><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        </div>
                    ';
            
            $array[$key] = [
                'no' => $no++,
                'nama_kelas' => $value->nama_kelas,
                'id_kelas' => $value->id_kelas,
                'id' => $value->id,
                'tanggal_mulai' => $value->tanggal_mulai,
                'menu' => $menu,
            ];
        }

        return response()->json(['data' => isset($array) ? $array : []]);
    }
    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'tanggal_mulai' => 'required',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $cek_kelas = PengaturanAbsensi::where('id_kelas',$request->id_kelas)->count();
        
        if ($cek_kelas > 0) {
            return response()->json(['cek' => 'gagal']);
        }
        $pengaturan = PengaturanAbsensi::create($request->all());

        if ($pengaturan) {
            return response()->json('berhasil');
        }
        return response()->json('gagal');
    }

    public function update(Request $request,$mulai) 
    {
        $validator = Validator::make($request->all(),[
            'tanggal_mulai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $pengaturan = PengaturanAbsensi::find($mulai);
        
        if ($pengaturan->update($request->all())) {
            return response()->json('berhasil');
        }
        return response()->json('gagal');
    }

    public function destroy($mulai)
    {
        $pengaturan = PengaturanAbsensi::find($mulai);
        if ($pengaturan->delete()) {
            return response()->json(['berhasil']);
        }
        return response()->json(['gagal']);
    }
}
