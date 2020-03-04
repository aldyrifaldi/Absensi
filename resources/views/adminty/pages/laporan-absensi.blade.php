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
                            <li>
                                <div class="form-group">
                                    <select onchange="kelas()" class="js-states form-control @error('id_kelas') is-invalid @enderror" name="" id="id_kelas">
                                        <option selected disabled value=" ">== PILIH KELAS ==</option>
                                    </select>
                                </div>
                            </li>
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md d-none" id="table-absensi">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center" width="3%">No.</th>
                                            <th rowspan="2" width="25%" class="text-center">Nama Santri</th>
                                            <th colspan="100" class="text-center">Absensi</th>
                                        </tr>
                                        <tr id="thead-daftar-absensi">
                                        </tr>
                                    </thead>
                                    <tbody id="daftar_santri">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md" id="tidak-ada">
                            <div class="text-center mt-4">
                                <i class="fa fa-5x fa-building" aria-hidden="true"></i>
                            </div>
                            <h2  class="text-center h2 mt-3 font-weight-bold">Pilih Kelas</h2>
                        </div>
                        <div class="col-md d-none" id="santri-tidak-ada">
                            <div class="text-center mt-4">
                                <i class="fa fa-5x fa-user" aria-hidden="true"></i>
                            </div>
                            <h2  class="text-center h2 mt-3 font-weight-bold">Santri Tidak Ada!</h2>
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


        $(document).ready(function(){
            
            axios({
                method: 'get',
                url: '{{url("api/kelas")}}',
            })
            .then(response => {

                var hasil = ''
                $('#tanggal_absensi').append(` <option selected disabled value=" ">== PILIH TANGGAL ABSENSI ==</option>`)

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
            $('#tidak-ada').addClass('d-none');
            $('#daftar_santri').html(' ');
            $('#thead-daftar-absensi').html(' ');

            axios({
                method: 'get',
                url: '{{url("api/data-absensi")}}/'+kelas,
            })
            .then(response => {
                console.log(response.data.data);
                if (response.data.data === []) {
                    $('#santri-tidak-ada').removeClass('d-none');
                    $('#tidak-ada').addClass('d-none');
                    $('#table-absensi').addClass('d-none');
                }
                else {

                    var hasil = ''
                    $('#table-absensi').removeClass('d-none');
                    var no = 1;

                    $.each(response.data.jadwal,function(y,x){
                        $('#thead-daftar-absensi').append(`
                            <th>${x.tanggal_absensi}</th>
                        `)
                    })

                    $.each(response.data.data,function(index,item){
                    
                        $('#daftar_santri').append(`
                                <tr id="baris-santri${item.id}">
                                    <td>${no++}</td>
                                    <td>${item.nama_santri}</td>
                                </tr>
                        `)

                        $.each(item.status,function(i, k){
                            if (k[0] == undefined) {
                                $('#baris-santri'+item.id).append(`
                                    <td>Hadir</td>
                                `)
                            }
                            else {
                                $('#baris-santri'+item.id).append(`
                                    <td>${k[0].status}</td>
                                `)
                            }
                        })
                        
                    })
                }
                $('#tanggal_absensi').append(hasil);
            })
        }
    </script>
@endpush