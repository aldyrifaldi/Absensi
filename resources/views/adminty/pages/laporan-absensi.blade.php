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
                                            <th colspan="500" class="text-center">Absensi</th>
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
            //get full 15 days before to 15 days after current date

            $scope = []; //Array where rest of the dates will be stored

            $scope.prevDate = moment().subtract(15, 'days');//15 days back date from today(This is the from date)

            $scope.nextDate = moment().add(15, 'days');//Date after 15 days from today (This is the end date)

            //extracting date from objects in MM-DD-YYYY format
            $scope.prevDate = moment($scope.prevDate._d).format('MM-DD-YYYY');
            $scope.nextDate = moment($scope.nextDate._d).format('MM-DD-YYYY');

            //creating JS date objects
            var start = new Date($scope.prevDate);
            var end = new Date($scope.nextDate);

            //Logic for getting rest of the dates between two dates("FromDate" to "EndDate")
            while(start < end){
                $scope.push(moment(start).format('ddd DD-MM'));
                var newDate = start.setDate(start.getDate() + 1);
                start = new Date(newDate);
            }

            console.log('Dates:- ');
            console.log($scope);




















            //get full date in current month
            var currentDate = moment().startOf('month');
            var futureMonthEnd = moment().endOf('month');
            var date = [];
            currentDate = moment(currentDate._d).format('MM-DD-YYYY');
            futureMonthEnd = moment(futureMonthEnd._d).format('MM-DD-YYYY');

            var start = new Date(currentDate);
            var end = new Date(futureMonthEnd);
            while (start <= end) {
                date.push(moment(start).format('ddd DD-MM'));
                var newDate = start.setDate(start.getDate() + 1);
                start = new Date(newDate);
            }


            
            // console.log('Tanggal dalam satu bulan',date);
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


                


                    // var hasil = ''
                    // $('#table-absensi').removeClass('d-none');
                    var no = 1;

                    // $.each(response.data.jadwal,function(y,x){
                    //     $('#thead-daftar-absensi').append(`
                    //         <th>${x.tanggal_absensi}</th>
                    //     `)
                    // })

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
                    
                    $.each(array_month,function(i,t){
                        var awal_hari = moment(t).startOf('month');
                        var akhir_hari = moment(t).endOf('month');
                        var day = [];
                        awal_hari = moment(awal_hari._d).format('MM-DD-YYYY');
                        akhir_hari = moment(akhir_hari._d).format('MM-DD-YYYY');
                        var mulai_hari = new Date(awal_hari);
                        var selesai_hari = new Date(akhir_hari);
                        while (mulai_hari <= selesai_hari) {
                            day.push(moment(mulai_hari).format('DD MMMM YYYY'));
                            var tanggal_baru = mulai_hari.setDate(mulai_hari.getDate() + 1);
                            mulai_hari = new Date(tanggal_baru);
                        }

                    
                        $.each(day,function(h,tanggal){
                            var string_tanggal = moment(tanggal).format('dddd');
                            var tanggal_hasil = response.data.jadwal.find(element => element === string_tanggal);
                            if (tanggal_hasil === undefined) {
                                
                            }
                            else {
                                $('#thead-daftar-absensi').append(`
                                    <th>${tanggal}</th>
                                `)

                            }
                        })
                    });

                }
                // $('#tanggal_absensi').append(hasil);
            })
        }
    </script>
@endpush