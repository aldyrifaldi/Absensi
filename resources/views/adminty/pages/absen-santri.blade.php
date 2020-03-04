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
                        <div class="col-md d-none" id="table-absensi">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="3%">No.</th>
                                            <th class="text-center">Nama Santri</th>
                                            <th class="text-center">Status Kehadiran</th>
                                            <th class="text-center">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="daftar_santri">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md d-none" id="tidak-ada">
                            <div class="text-center mt-4">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <h2  class="text-center h2 font-weight-bold">Santri tidak ada</h2>
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

            $('#tidak-ada').addClass('d-none');
            var tanggal = $('#tanggal_absensi').val();
            var kelas = $('#id_kelas').val();
            axios({
                method: 'get',
                url: '{{url("api/data-absen-santri")}}/'+kelas+'/'+tanggal,
            })
            .then((response) => {
                var santri = $('#daftar_santri');
                var no = 1; 
                var value_pilihan = ['Izin','Alfa'];

                if (response.data.length == 0) {
                    $('#tidak-ada').removeClass('d-none');
                }
                
                $('#daftar_santri tr').html(' ');

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
                    
                    var no_detail_absensi = item.no_detail_absensi;
                    santri.append(`
                        <tr id="list-santri">
                            <td scope="row">${no++}</td>
                            <td>${item.nama_santri}</td>
                            <td>
                                <div class="form-group">    
                                    <select onchange="kirimStatus(${item.id_santri},${no_detail_absensi})" class="form-control" name="id_santri" id="id_santri">
                                        <option disabled value=" ">== Status Absensi ==</option>
                                        <option selected value="Hadir">Hadir</option>
                                        `+
                                            hasil_pilihan
                                        +`
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input value="`+(item.alasan == null ? '': item.alasan) +`" onkeyup="alasan(${item.id_santri},${no_detail_absensi})" type="text" name="alasan" class="form-control" id="alasan${item.id_santri}" placeholder="Keterangan">
                                </div>
                            </td>
                        </tr>
                    `)

                    if (item.status === null) {
                        $('#alasan'+item.id_santri).attr('readonly',true);
                    }
                    else{
                        $('#alasan'+item.id_santri).removeAttr('readonly');
                    }
                })
            }).catch((err) => {

            })
        }



        function alasan(id_santri,no_detail_absensi){
            var alasan = $('#alasan'+id_santri).val();
            var id_santri = id_santri;
            var no_detail_absensi = no_detail_absensi;
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
            }).catch((err) => {
                
            });
        }


        function kirimStatus(id_santri,no_detail_absensi) {
            var id_santri = id_santri;
            var no_detail = no_detail_absensi;
            var status = $('#id_santri').val();

            if (status !== 'Hadir' ) {
                $('#alasan'+id_santri).removeAttr('readonly');
            }
            else {
                $('#alasan'+id_santri).attr('readonly',true);
                $('#alasan'+id_santri).val('');
                
            }

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
            $('#tidak-ada').addClass('d-none');

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