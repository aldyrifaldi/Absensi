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
                        <div class="col-md-2">
                            <ul class="list-unstyled card-option">
                                <li>
                                    <div class="form-group">
                                        <select onchange="tahun()" class="js-states form-control d-none @error('id_tahun') is-invalid @enderror" name="" id="option_tahun">
                                            <option selected disabled value=" ">== PILIH TAHUN ==</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <ul class="list-unstyled card-option">
                                <li>
                                    <div class="form-group">
                                        <select onchange="bulan()" class="js-states form-control d-none @error('id_bulan') is-invalid @enderror" name="" id="option_bulan">
                                            <option selected disabled value=" ">== PILIH BULAN ==</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="mr-auto"></div>
                        <div class="col-md-2">
                            <ul class="list-unstyled card-option">
                                <li>
                                    <div class="form-group">
                                        <input type="text" placeholder="Cari santri" name="cari_santri" id="cari_santri" class="form-control d-none">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md d-none" id="table-absensi">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="3" class="text-center" width="3%">No.</th>
                                            <th rowspan="3" width="25%" class="text-center">Nama Santri</th>
                                            <th colspan="500" class="text-center">Absensi</th>
                                        </tr>
                                        <tr id="bulan_absensi_santri">
                                        </tr>
                                        <tr id="tanggal_absensi_santri">
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

            $('#option_tahun').removeClass('d-none');
            $('#option_bulan').removeClass('d-none');
            $('#cari_santri').removeClass('d-none');
            $('#tidak-ada').addClass('d-none');
            $('#daftar_santri').html(' ');
            $('#bulan_absensi_santri').html(' ');
            $('#tanggal_absensi_santri').html(' ');

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

                    var no = 1;

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


                      //get full date in one year

                    var startMonth = moment().startOf('year');
                    var endMonth = moment().endOf('year');
                    var array_month = [];
                    var string_month = [];
                    startMonth = moment(startMonth._d).format('MM-DD-YYYY');
                    endMonth = moment(endMonth._d).format('MM-DD-YYYY');
                    var start = new Date(startMonth);
                    var end = new Date(endMonth);
                    while (start <= end) {
                        array_month.push(moment(start).format('MM-DD-YYYY'));
                        string_month.push(moment(start).format('MMMM'));
                        var newMonth = start.setMonth(start.getMonth() + 1);
                        start = new Date(newMonth);
                    }

                    var hasil = ''
                    $('#table-absensi').removeClass('d-none');

                    $.each(string_month,function(q,u){
                        $('#option_bulan').append(`
                            <option value="${u}">${u}</option>
                        `)
                    })
                    
                    var tanggal_perbulan = [];
                    var string_tanggal_perbulan = [];
                    $.each(array_month,function(i,t){
                        var awal_hari = moment(t).startOf('month');
                        var akhir_hari = moment(t).endOf('month');
                        var day = [];
                        var string_day = [];
                        awal_hari = moment(awal_hari._d).format('MM-DD-YYYY');
                        akhir_hari = moment(akhir_hari._d).format('MM-DD-YYYY');
                        var mulai_hari = new Date(awal_hari);
                        var selesai_hari = new Date(akhir_hari);
                        while (mulai_hari <= selesai_hari) {
                            day.push(moment(mulai_hari).format('MM/DD'));
                            string_day.push(moment(mulai_hari).format('dddd'));
                            var tanggal_baru = mulai_hari.setDate(mulai_hari.getDate() + 1);
                            mulai_hari = new Date(tanggal_baru);
                        }
                        
                        tanggal_perbulan.push(day);
                        string_tanggal_perbulan.push(string_day);

                    });

                    var no = 0;
                    $.each(string_tanggal_perbulan,function(r,w){
                        
                        Array.prototype.diff = function(arr2) {
                            var ret = [];
                            this.sort();
                            arr2.sort();
                            for(var i = 0; i < this.length; i += 1) {
                                if(arr2.indexOf(this[i]) > -1){
                                    ret.push(this[i]);
                                }
                            }
                            return ret;
                        };

                        var colspan = w.diff(response.data.jadwal);
                        console.log(colspan.length);
                        var daftar_bulan = moment().startOf('year');
                        daftar_bulan = moment(daftar_bulan._d).format('MM-DD-YYYY');
                        var daftar_bulan = new Date(daftar_bulan);

                        //tinggal di increment agar bisa mulai dari januari sampai dengan desember 
                        var bulan_tambah = daftar_bulan.setMonth(daftar_bulan.getMonth() + no++);
                        var bulan_plus = new Date(bulan_tambah);
                        
                        $('#bulan_absensi_santri').append(`
                            <th class="text-center" colspan="${colspan.length}">${moment(bulan_plus).format('MMMM')}</th>
                        `)
                    })


                    $.each(tanggal_perbulan,function(h,bulan){
                        
                        $.each(bulan,function(t,tanggal){
                            var string_tanggal = moment(tanggal).format('dddd').toString();
                            var tanggal_hasil = response.data.jadwal.find(element => element === string_tanggal);
                            if (tanggal_hasil === undefined) {
                                
                            }
                            else {
                                $('#tanggal_absensi_santri').append(`
                                    <th>${tanggal}</th>
                                `);
                            }
                        })
                        })
                }
            })
        }
    </script>
@endpush