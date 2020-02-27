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
                                <label for="id_kelas">Kelas</label>
                                <select onchange="kelas()" class="js-states form-control @error('id_kelas') is-invalid @enderror" name="" id="id_kelas">
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="tanggal_absensi">Tanggal Absensi</label>
                                <select onchange="tanggalAbsensi()" class="form-control @error('tanggal_absensi') is-invalid @enderror" name="" id="tanggal_absensi">
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
            console.log(tanggal);
            axios({
                method: ''
            })
        }

        $(document).ready(function(){
            axios({
                method: 'get',
                url: '{{url("api/kelas")}}',
            })
            .then(response => {
                $('#id_kelas').append(`
                    <option selected disabled value=" ">== PILIH KELAS ==</option>
                `)
                $('#tanggal_absensi').append(`
                    <option selected disabled value=" ">== PILIH TANGGAL ABSENSI ==</option>
                `)

                var hasil = ''
                $.each(response.data,function(index,item){
                    var option = `
                        <option value="${item.id}">${item.nama_kelas}</option>
                    `

                    hasil += option
                })

                $('#id_kelas').append(hasil);
            })
        })

        function kelas(){
            var kelas = $('#id_kelas').val();
            axios({
                method: 'get',
                url: '{{url("api/jadwal-perkelas")}}/'+kelas,
            })
            .then(response => {
                var hasil = ''
                $.each(response.data,function(index,item){
                    var option = `
                        <option value="${item.format_date}">${item.string_tanggal}</option>
                    `

                    hasil += option
                })

                $('#tanggal_absensi').append(hasil);
            })
        }
    </script>
@endpush