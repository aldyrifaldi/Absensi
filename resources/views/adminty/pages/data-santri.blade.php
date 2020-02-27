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
                    <h5 class="card-title font-weight-bold">Daftar Santri</h5>
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
                                    <th class="text-center">Nama Santri</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Kelas</th>
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
                                        <td>{{$item->nama_santri}} </td>
                                        <td>{{$item->alamat}} </td>
                                        <td>{{$item->nama_kelas}} </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button data-toggle="modal" data-target="#edit{{$item->id_santri}}" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> </button>
                                                <button data-toggle="modal" data-target="#hapus{{$item->id_santri}}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="hapus{{$item->id_santri}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="text-white font-weight-bold">Hapus Santri</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span class="text-white font-weight-bold" aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    Anda ingin menghapus <strong class="text-danger">{{$item->nama_santri}} ?</strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{route('santri.destroy',$item->id_santri)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="edit{{$item->id_santri}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="text-white font-weight-bold">Edit Santri</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span class="text-white font-weight-bold" aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <form action="{{route('santri.update',$item->id_santri)}}" method="post">
                                                    @csrf
                                                    @method('put')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="@error('nama_santri') text-danger @enderror" for="nama_santri">Nama Santri</label>
                                                        <input value="{{$item->nama_santri}}" required type="text" placeholder="Nama Santri" name="nama_santri" id="nama_santri" class="form-control @error('nama_santri') is-invalid @enderror">
                                                        <small>Masukkan Nama Santri</small>
                                                        <br>
                                                        @error('nama_santri')
                                                            <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="@error('alamat') text-danger @enderror" for="alamat">Alamat</label>
                                                        <input value="{{$item->alamat}}" required type="text" placeholder="Alamat Santri" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">
                                                        <small>Masukkan Alamat Yang Valid</small>
                                                        <br>
                                                        @error('alamat')
                                                            <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="@error('id_kelas') text-danger @enderror" for="id_kelas">Kelas | <a class="text-info" href="{{url('admin/data-kelas')}}">Tambah Kelas</a></label>
                                                        <select required class="form-control @error('id_kelas') is-invalid @enderror" name="id_kelas" id="id_kelas">
                                                            <option selected disabled value=" ">== PILIH KELAS ==</option>
                                                            @foreach ($kelas as $k)
                                                            <option @if($k->id == $item->id_kelas) {{'selected'}} @endif value="{{$k->id}}">{{$k->nama_kelas}}</option>
                                                            @endforeach
                                                        </select>
                                                        <small>Pilih Kelas Santri</small>
                                                        <br>
                                                        @error('id_kelas')
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
                    <h5 class="card-title">Tambah Santri</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('santri.store')}}" method="post">
                        @csrf
                    <div class="form-group">
                        <label class="@error('nama_santri') text-danger @enderror" for="nama_santri">Nama Santri</label>
                        <input required type="text" placeholder="Nama Santri" name="nama_santri" id="nama_santri" class="form-control @error('nama_santri') is-invalid @enderror">
                        <small>Masukkan Nama Santri</small>
                        <br>
                        @error('nama_santri')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="@error('alamat') text-danger @enderror" for="alamat">Alamat</label>
                        <input required type="text" placeholder="Alamat Santri" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">
                        <small>Masukkan Alamat Yang Valid</small>
                        <br>
                        @error('alamat')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="@error('id_kelas') text-danger @enderror"  for="id_kelas">Kelas | <a class="text-info" href="{{url('admin/data-kelas')}}">Tambah Kelas</a></label>
                        <select required class="form-control @error('id_kelas') is-invalid @enderror" name="id_kelas" id="id_kelas">
                            <option selected disabled value=" ">== PILIH KELAS ==</option>
                            @foreach ($kelas as $k)
                            <option value="{{$k->id}}">{{$k->nama_kelas}}</option>
                            @endforeach
                        </select>
                        <small>Pilih Kelas Santri</small>
                        <br>
                        @error('id_kelas')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Santri</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection