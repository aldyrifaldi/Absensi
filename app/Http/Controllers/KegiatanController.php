<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kegiatan;
use Alert;
use Illuminate\Support\Facades\Validator;
use App\Kelas;
class KegiatanController extends Controller
{
    public function index() 
    {
        $pengaturan = Kegiatan::select('*','Kelas.id as id_kelas','kegiatan.id as id')->join('Kelas','Kelas.id','=','kegiatan.id_kelas')->get();
        $no = 1;
        foreach ($pengaturan as $key => $value) {
            $menu = '   
                        <div class="btn-group">
                            <button type="button" data-toggle="modal" class="btn btn-warning btn-sm" data-target="#edit'.$value->id.'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button type="button" data-toggle="modal" onclick="hapus('.$value->id.')" class="btn btn-sm btn-danger" data-target="#hapus'.$value->id.'."><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        </div>
                    ';

            $array[$key] = [
                'id' => $value->id,
                'no' => $no++.'.',
                'kegiatan' => $value->kegiatan,
                'id_kelas' => $value->id_kelas,
                'nama_kelas' => $value->nama_kelas,
                'tanggal_mulai' => $value->tanggal_mulai,
                'tanggal_berakhir' => $value->tanggal_berakhir,
                'menu' => $menu,
            ];
        }

        $kelas = Kelas::get();
        return response()->json([ 
            'data' => isset($array) ? $array : [],
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'kegiatan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $pengaturan = Kegiatan::create($request->all());

        if ($pengaturan) {
            return response()->json('berhasil');
        }
        return response()->json('gagal');
    }

    public function update(Request $request,$kegiatan) 
    {
        $validator = Validator::make($request->all(),[
            'kegiatan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
            'id_kelas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $pengaturan = Kegiatan::find($kegiatan)->update($request->all());

        if ($pengaturan) {
            return response()->json('berhasil');
        }
        return response()->json('gagal');
    }

    public function destroy($kegiatan)
    {
        $pengaturan = Kegiatan::find($kegiatan);
        if ($pengaturan->delete()) {
            return response()->json(['berhasil']);
        }
        return response()->json(['gagal']);
    }
}
