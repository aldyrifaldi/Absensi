@extends('adminty.layouts')

@section('content')
<!-- Page-header start -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>{{str_replace('-',' ',$pages)}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->
    
<div class="page-body">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title font-weight-bold">Daftar Kelas</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th class="text-center">Nama Kelas</th>
                                    <th class="text-center w-25">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $item)
                                    <tr>
                                        <td scope="row">{{$no++}}.</td>
                                        <td>{{$item->nama_kelas}} </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button data-toggle="modal" data-target="#edit{{$item->id}}" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> </button>
                                                <button data-toggle="modal" data-target="#hapus{{$item->id}}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="hapus{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="text-white font-weight-bold">Hapus Kelas</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span class="text-white font-weight-bold" aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    Anda ingin menghapus kelas <strong class="text-danger">{{$item->nama_kelas}} ?</strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{route('kelas.destroy',$item->id)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="text-white font-weight-bold">Edit Kelas</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span class="text-white font-weight-bold" aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <form action="{{route('kelas.update',$item->id)}}" method="post">
                                                    @csrf
                                                    @method('put')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="@error('nama_kelas') text-danger @enderror" for="nama_kelas">Nama Kelas</label>
                                                        <input value="{{$item->nama_kelas}}" required type="text" placeholder="Nama Kelas" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror">
                                                        <small>Masukkan Nama Kelas</small>
                                                        <br>
                                                        @error('nama_kelas')
                                                            <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tambah Kelas</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('kelas.store')}}" method="post" role="form">
                        @csrf
                    <div class="form-group">
                        <label class="@error('nama_kelas') text-danger @enderror" for="nama_kelas">Nama Kelas</label>
                        <input value="{{old('nama_kelas')}}" required type="text" placeholder="Nama Kelas" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror">
                        <small>Masukkan Nama Kelas</small>
                        <br>
                        @error('nama_kelas')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Guru</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection