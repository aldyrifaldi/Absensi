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
        <div class="col-md">
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
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="tanggal_absensi">Tanggal Absensi</label>
                                <select onchange="tanggalAbsensi()" class="form-control @error('tanggal_absensi') is-invalid @enderror" name="" id="select2">
                                    <option selected disabled value=" ">== PILIH TANGGAL ABSENSI ==</option>
                                    @foreach ($tanggal as $item)
                                        <option value=""></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="id_kelas">Kelas</label>
                                <select class="form-control @error('id_kelas') is-invalid @enderror" name="" id="select2">
                                    <option selected disabled value=" ">== PILIH KELAS ==</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="table-responsive" id="table-absensi">
                                <table class="table table-bordered datatable table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">No.</th>
                                            <th class="text-center">Nama Santri</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope="row"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td scope="row"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@push('script')
    <script>
        function tanggalAbsensi(){
            var tanggal = $('#tanggal_absensi').val();
            location.href = "{{url()->current()}}?tg="+tanggal;
        }
    </script>
@endpush