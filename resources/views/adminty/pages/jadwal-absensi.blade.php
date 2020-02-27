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
    <div class="row" id="list-kelas">
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            axios({
                method: 'get',
                url: '{{url("api/jadwal-absensi")}}',
            })
            .then(response => {
                var pilihan_hari = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                $.each(response.data,function(i, item){
                    var option_hari = item
                    
                    pilihan_element = '';
                    
                    var option = item.id_kelas-1;
                    
                    function pilihanHari(value, index, array){
                        var show = [
                            {
                                Monday: 'Senin',
                                Tuesday: 'Selasa',
                                Wednesday: 'Rabu',
                                Thursday: 'Kamis',
                                Friday: 'Jumat',
                                Saturday: 'Sabtu',
                                Sunday: 'Ahad',
                            }
                        ];

                        console.log(item.nama_hari[0][value] == value);


                        var this_element = `
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input `+
                                                    (item.nama_hari[0][value] === value ? 'checked' : '') 
                                                +
                                                `   onchange="checkbox(${item.id_kelas})" value="${value}" class="border-checkbox checkbox${item.id_kelas}" name="nama_hari[]" type="checkbox" id="checkbox${index}${item.id_kelas}">
                                                <label class="border-checkbox-label" for="checkbox${index}${item.id_kelas}">${show.map(e => e[value])}</label>
                                            </div>
                                            `
                        
                        pilihan_element += this_element; 
                    }

                    var element =  pilihan_hari.forEach(pilihanHari);

                    var list = `
                        <div class="col-md">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title font-weight-bold">${item.nama_kelas}</div>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="feather icon-maximize full-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="border-checkbox-section">
                                        `
                                        + pilihan_element +
                                        `
                                    </div>
                                </div>
                            </div>
                        </div>
                        `
                        $('#list-kelas').append(
                            list
                        )
                })
            })
        })

        function checkbox(kelas){
            var hari = [];
            $(".checkbox"+kelas+":checked").each(function(){
                hari.push($(this).val()); 
            });
            var kelas = kelas;
            console.log(hari);
            axios({
                method: 'post',
                url: '{{url("api/jadwal-absensi/store")}}',
                data: {
                    hari: hari,
                    kelas: kelas,
                }
            })
            .then(response => {
                console.log(response.data);  
            })
        }

    </script>
@endpush