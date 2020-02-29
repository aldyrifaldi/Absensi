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
                                    <option selected disabled value=" ">== PILIH KELAS ==</option>
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
                            <div class="table-responsive d-none" id="table-absensi">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">No.</th>
                                            <th class="text-center">Nama Santri</th>
                                            <th class="text-center">Status Kehadiran</th>
                                            <th class="text-center">Alasan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="daftar_santri">
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

{{-- testing comment --}}




@endsection

@push('script')
    <script>
        function tanggalAbsensi(){
            var tanggal = $('#tanggal_absensi').val();
            var kelas = $('#id_kelas').val();
            console.log(tanggal);
            axios({
                method: 'get',
                url: '{{url("api/data-absen-santri")}}/'+kelas+'/'+tanggal,
        })
        .then((response) => {
            console.log(response.data);
            var santri = $('#daftar_santri');
            var no = 1; 
            var value_pilihan = ['Hadir','Izin','Alfa'];

            $.each(response.data,function(index,item){

                $('#table-absensi').removeClass('d-none'); 
                var hasil_pilihan = '';
                function optionStatus(value, index, array){
                    if (item.status == value) {
                        var pilihan = `
                        <option selected value="${value}">${value}</option>
                    `
                    }
                    else{
                        var pilihan = `
                            <option value="${value}">${value}</option>
                        `
                    }
                    

                    hasil_pilihan += pilihan;
                }
                value_pilihan.forEach(optionStatus)

                console.log(item.alasan);
                var no_detail_absensi = item.no_detail_absensi;
                santri.append(`
                    <tr>
                        <td scope="row">${no++}</td>
                        <td>${item.nama_santri}</td>
                        <td>
                            <div class="form-group">    
                                <select onchange="kirimStatus(${item.id_santri},${no_detail_absensi})" class="form-control" name="id_santri" id="id_santri">
                                    <option selected disabled value=" ">== Status Absensi ==</option>
                                    `+
                                        hasil_pilihan
                                    +`
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input value="`+(item.alasan == null ? '': item.alasan) +`" onkeypress="alasan(${item.id_santri},${no_detail_absensi})" type="text" name="alasan" class="form-control" id="alasan" placeholder="Alasan">
                            </div>
                        </td>
                    </tr>
                `)
            })
        }).catch((err) => {
            
        })
        }


        function alasan(id_santri,no_detail_absensi){
            var alasan = $('#alasan').val();
            var id_santri = id_santri;
            var no_detail_absensi = no_detail_absensi;
            console.log(no_detail_absensi);
            axios({
                method: 'post',
                url: '{{url("api/alasan/store")}}',
                data: {
                    alasan: alasan,
                    no_detail_absensi: no_detail_absensi,
                    id_santri: id_santri,
                }
            })
            .then((response) => {
                console.log(response);
            }).catch((err) => {
                
            });
        }


        function kirimStatus(id_santri,no_detail_absensi) {
            var id_santri = id_santri;
            var no_detail = no_detail_absensi;
            console.log(no_detail);
            var status = $('#id_santri').val();
            
            axios({
                method: 'post',
                url: '{{route("absen.store")}}',
                data: {
                    id_santri: id_santri,
                    status: status,
                    no_detail_absensi: no_detail,
                },
            })
            .then((response) => {
                console.log(response.data);    
            }).catch((err) => {
                
            });
        }

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
            axios({
                method: 'get',
                url: '{{url("api/jadwal-perkelas")}}/'+kelas,
            })
            .then(response => {
                $('#tanggal_absensi').html(' ');
                $('#tanggal_absensi').append(` <option selected disabled value=" ">== PILIH TANGGAL ABSENSI ==</option>`)
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