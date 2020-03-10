@extends('adminty.layouts')

@section('content')
{{-- <style>
    .swal2-confirm {
        padding:0!important;
    }
</style> --}}
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
        <div class="col-xl-6 col-md-6 col-sm-6">
            <div class="card bg-c-yellow update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white font-weight-bold">Mulai Absensi</h4>
                            <h3 class="text-dark font-weight-bold mt-3"><a data-toggle="modal" style="cursor: pointer" data-target="#daftar-mulai"> Lihat Daftar</a></h3>
                        </div>
                        <div class="col-4 text-right">
                            <i style="cursor: pointer" class="fa fa-cog fa-5x" data-target="#mulai-absensi" data-toggle="modal" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 col-sm-6">
            <div class="card bg-c-lite-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white font-weight-bold">Jumlah Kegiatan</h4>
                            <h3 class="text-white font-weight-bold mt-3">500</h3>
                        </div>
                        <div class="col-4 text-right">
                            <i style="cursor: pointer" data-toggle="modal" data-target="#tambah"  class="fa fa-plus-square-o fa-5x" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="daftar-mulai" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-c-lite-green ">
                    <h5 class="modal-title text-white font-weight-bold">Daftar Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="table-daftar-mulai" class="table table-bordered display table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th class="text-center">Nama Kelas</th>
                                    <th class="text-center">Tanggal Mulai Absensi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot class="thead-light">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th class="text-center">Nama Kelas</th>
                                    <th class="text-center">Tanggal Mulai Absensi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-area">
    </div>
    <div class="modal fade" id="mulai-absensi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-c-green">
                    <h5 class="modal-title font-weight-bold text-white">Mulai Absensi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="mulai_absensi">Tanggal Mulai Absensi</label>
                        <input type="date" class="form-control" name="mulai_absensi" id="mulai_absensi">
                        <small>Masukkan tanggal absensi</small>
                    </div>
                    <div class="form-group">
                        <label for="id_kelas">Nama Kelas</label>
                        <select class="form-control" name="id_kelas" id="id_kelas_mulai">
                            <option value="">== PILIH KELAS ==</option>
                            @foreach ($kelas as $item)
                            <option value="{{$item->id}}">{{$item->nama_kelas}}</option>
                            @endforeach
                        </select>
                        <small>Pilih Kelas</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="mulaiAbsensi()">Atur</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-c-orenge">
                    <h5 class="modal-title text-white font-weight-bold">Tambah Kegiatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="@error('kegiatan') text-danger @enderror" for="kegiatan">Nama Kegiatan</label>
                        <input value="{{old('kegiatan')}}" required type="text" placeholder="Nama Kegiatan" name="kegiatan" id="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror">
                        <small>Masukkan Nama Kegiatan</small>
                        <br>
                        @error('kegiatan')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_kelas">Nama Kelas</label>
                        <select class="form-control" name="id_kelas" id="id_kelas">
                            <option selected disabled value="">== PILIH KELAS ==</option>
                            @foreach ($kelas as $k)
                            <option value="{{$k->id}}">{{$k->nama_kelas}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="@error('tanggal_mulai') text-danger @enderror" for="tanggal_mulai">Tanggal Mulai</label>
                        <input value="{{old('tanggal_mulai')}}" required type="date" placeholder="Tanggal Mulai" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror">
                        <small>Masukkan Tanggal Mulai</small>
                        <br>
                        @error('tanggal_mulai')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="@error('tanggal_berakhir') text-danger @enderror" for="tanggal_berakhir">Tanggal Berakhir</label>
                        <input value="{{old('tanggal_berakhir')}}" required type="date" placeholder="Tanggal Berakhir" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control @error('tanggal_berakhir') is-invalid @enderror">
                        <small>Masukkan Tanggal Berakhir</small>
                        <br>
                        @error('tanggal_berakhir')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" onclick="create()" class="btn btn-primary font-weight-bold">Tambah Kegiatan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title font-weight-bold">Daftar Kegiatan</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="daftar-jadwal" class="table table-bordered display table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th class="text-center">Nama Kegiatan</th>
                                    <th class="text-center">Kelas</th>
                                    <th class="text-center">Tanggal Mulai</th>
                                    <th class="text-center">Tanggal Berakhir</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot class="thead-light">
                                <tr>
                                    <th class="text-center" width="3%">No.</th>
                                    <th class="text-center">Nama Kegiatan</th>
                                    <th class="text-center">Kelas</th>
                                    <th class="text-center">Tanggal Mulai</th>
                                    <th class="text-center">Tanggal Berakhir</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            axios({
                url: '{{route("kegiatan.index")}}',
            })
            .then((response) => {
                
                var table =  $('#daftar-jadwal').DataTable( {
                    responsive: true,
                    "ajax": {
                        'url' : '{{route("kegiatan.index")}}',
                        'type': 'GET'
                    },
                    "columns": [
                        { "data": "no" },
                        { "data": "kegiatan" },
                        { "data": "nama_kelas" },
                        { "data": "tanggal_mulai" },
                        { "data": "tanggal_berakhir" },
                        { "data": "menu" },
                    ]
                });

                
                $.each(response.data.data,function(index,item){
                    var option_kelas = '';

                    function optionStatus(value, index, array){
                        if (item.id_kelas == value.id) {
                            var pilihan = `
                            <option selected value="${value.id}">${value.nama_kelas}</option>
                        `
                        }
                        else{
                            var pilihan = `
                                <option value="${value.id}">${value.nama_kelas}</option>
                            `
                        }
                        
                        option_kelas += pilihan;
                    }
                    response.data.kelas.forEach(optionStatus)


                    $('#modal-area').append(`
                        <div class="modal fade" id="edit${item.id}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title font-weight-bold">Edit Kegiatan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span class="text-white" aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="kegiatan">Nama Kegiatan</label>
                                            <input type="text" value="${item.kegiatan}" name="kegiatan" placeholder="Nama Kegiatan" id="kegiatan${item.id}" class="form-control">
                                            <small>Masukkan Nama Kegiatan</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_kelas">Nama Kelas</label>
                                            <select class="form-control" name="id_kelas" id="id_kelas${item.id}">
                                                <option selected disabled value="">== PILIH KELAS ==</option>
                                                `+ option_kelas +`
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai</label>
                                            <input type="date" value="${item.tanggal_mulai}" placeholder="Tanggal Mulai" name="tanggal_mulai" id="tanggal_mulai${item.id}" class="form-control">
                                            <small>Masukkan Tanggal Mulai</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_berakhir">Tanggal Berakhir</label>
                                            <input type="date" value="${item.tanggal_berakhir}" placeholder="Tanggal Berakhir" name="tanggal_berakhir" id="tanggal_berakhir${item.id}" class="form-control">
                                            <small>Masukkan Tanggal Berakhir</small> 
                                        </div>                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="button" onclick="edit(${item.id})" class="btn btn-warning">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `)
                })

            })

            axios({
            
                url: '{{route("pengaturan-absensi.index")}}',
            })
            .then((response) => {
                
                var table =  $('#table-daftar-mulai').DataTable( {
                    responsive: true,
                    "ajax": {
                        'url' : '{{route("pengaturan-absensi.index")}}',
                        'type': 'GET'
                    },
                    "columns": [
                        { "data": "no" },
                        { "data": "nama_kelas" },
                        { "data": "tanggal_mulai" },
                        { "data": "menu" },
                    ]
                });
            }).catch((err) => {
                
            });

        })

        function mulaiAbsensi() {
            var tanggal_mulai = $('#mulai_absensi').val();
            var id_kelas = $('#id_kelas_mulai').val();
            
            axios({
                method: 'post',
                url: '{{route("pengaturan-absensi.store")}}',
                data: {
                    tanggal_mulai: tanggal_mulai,
                    id_kelas: id_kelas,
                }
            })
            .then((response) => {
                if (response.data == 'berhasil') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data kegiatan berhasil dikirim',
                            showConfirmButton: true,
                            timer: 1500
                        })
                        var table =  $('#table-daftar-mulai').DataTable();
                        table.ajax.reload(); 
                        $('#mulai_absensi').val('');
                        $('#id_kelas_mulai').val('');
                    }
                    else if (response.data == 'gagal') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Server',
                            showConfirmButton: true,
                            timer: 1500
                        })
                    }
                    else if (response.data.tanggal_mulai || response.data.id_kelas) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Form wajib diisi!',
                            showConfirmButton: true,
                            timer: 1500
                        })
                    }
                    else if (response.data.cek) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kelas telah diatur sebelumnya!',
                        showConfirmButton: true,
                        timer: 1500
                    })
                }
                    $('#mulai-absensi').modal('hide');
            })
        }

        function editMulai(id_mulai,tahun,bulan,tanggal) {
            $('#daftar-mulai').modal('hide');
            var id_mulai = id_mulai;
            var tanggal_mulai = bulan+'/'+tanggal+'/'+tahun;
            Swal.fire({
                title: 'Tanggal mulai',
                input: 'text',
                inputValue: tanggal_mulai,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    `<i class="fa fa-pencil-square"></i> Simpan!`,
                cancelButtonText:
                    'Batal',
            })
            .then((result) => {
                if (!result.value) {
                    $('#daftar-mulai').modal('show');
                }
                else {
                    kirimEditMulai(id_mulai,result.value)
                }
            })
            $('.swal2-input').datepicker();
            $('.swal2-input').attr('readonly',true)
        }

    function kirimEditMulai(id_mulai,tanggal_mulai) {
        var id_mulai = id_mulai;
        var tanggal_mulai = moment(tanggal_mulai).format('YYYY-MM-DD');
        
        axios({
            method: 'put',
            url: '{{url("api/pengaturan-absensi")}}/'+id_mulai,
            data: {
                tanggal_mulai: tanggal_mulai,
            }
        })
        .then((response) => {
            if (response.data == 'berhasil') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Perubahan telah tersimpan',
                    showConfirmButton: true,
                })
                .then((result) => {
                    $('#daftar-mulai').modal('show');
                })
                var table =  $('#table-daftar-mulai').DataTable();
                table.ajax.reload(); 
            }
            else if (response.data.tanggal_mulai) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak boleh kosong',
                    showConfirmButton: true,
                })
                .then((result) => {
                    $('#daftar-mulai').modal('show');
                })
                var table =  $('#table-daftar-mulai').DataTable();
                table.ajax.reload(); 
            }
            else if (response.data.cek) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kelas telah diatur sebelumnya!',
                    showConfirmButton: true,
                    timer: 1500
                })
                .then((result) => {
                    $('#daftar-mulai').modal('show');
                })
            }
        })
    }

    function edit(id_kegiatan) {
        var id_kegiatan = id_kegiatan;
        var kegiatan = $('#kegiatan'+id_kegiatan).val();
        var tanggal_mulai = $('#tanggal_mulai'+id_kegiatan).val();
        var tanggal_berakhir = $('#tanggal_berakhir'+id_kegiatan).val();
        var id_kelas = $('#id_kelas'+id_kegiatan).val();

        axios({
            method: 'put',
            url: '{{url("api/kegiatan")}}/'+id_kegiatan,
            data: {
                kegiatan: kegiatan,
                tanggal_mulai: tanggal_mulai,
                tanggal_berakhir: tanggal_berakhir,
                id_kelas: id_kelas,
            }
        })
        .then((response) => {
            if (response.data == 'berhasil') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data kegiatan berhasil diupdate',
                    showConfirmButton: true,
                })
                $('.modal').modal('hide');
                var table =  $('#daftar-jadwal').DataTable();
                table.ajax.reload(); 
            }
        })
    }

    function hapus(id_kegiatan) {
        var id_kegiatan = id_kegiatan;
        Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak dapat mengembalikan data ini lagi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Ini!'
        }).then((result) => {
            if (result.value) {
                axios({
                    method: 'delete',
                    url: '{{url("api/kegiatan")}}/'+id_kegiatan,
                })
                .then((response) => {
                    if (response.data == 'berhasil') {
                        Swal.fire(
                            'Terhapus!',
                            'Data telah terhapus.',
                            'success'
                        );
                        var table =  $('#daftar-jadwal').DataTable();
                        table.ajax.reload(); 
                    }
                    else {
                        Swal.fire(
                            'Gagal!',
                            'Internal server error.',
                            'error'
                        );

                    }
                })
            }
        })
    }


    function hapusMulai(id_mulai) {
        var id_mulai = id_mulai;
        $('#daftar-mulai').modal('hide');
        Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak dapat mengembalikan data ini lagi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Ini!'
        }).then((result) => {
            if (result.value) {
                axios({
                    method: 'delete',
                    url: '{{url("api/pengaturan-absensi")}}/'+id_mulai,
                })
                .then((response) => {
                    if (response.data == 'berhasil') {
                        Swal.fire({
                            timer: 1500,

                            title: 'Terhapus!',
                            text: 'Data telah terhapus.',
                            icon: 'success',
                        })
                        .then((result) => {
                            $('#daftar-mulai').modal('show');
                        });
                        var table =  $('#table-daftar-mulai').DataTable();
                        table.ajax.reload(); 
                    }
                    else {
                        Swal.fire(
                            'Gagal!',
                            'Internal server error.',
                            'error'
                        )
                        .then((result) => {
                            $('#daftar-mulai').modal('show');
                        });
                    }
                })

            }
        })
    }


    function create() {
            var kegiatan = $('#kegiatan').val();
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_berakhir = $('#tanggal_berakhir').val();
            var id_kelas = $('#id_kelas').val();
            axios({
                method: 'post',
                url: '{{route("kegiatan.store")}}',
                data: {
                    kegiatan: kegiatan,
                    tanggal_mulai: tanggal_mulai,
                    tanggal_berakhir: tanggal_berakhir,
                    id_kelas: id_kelas,
                }
            })
            .then((response) => {
                if (response.data == 'berhasil') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Kegiatan telah ditambahkan',
                        showConfirmButton: true,
                        timer: 2500
                    })
                    var table =  $('#daftar-jadwal').DataTable();
                    table.ajax.reload(); 
                    $('#kegiatan').val('');
                    $('#tanggal_mulai').val('');
                    $('#tanggal_berakhir').val('');
                    $('#id_kelas').val('');
                    $('#tambah').modal('hide');
                }
                else if (response.data == 'gagal') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Server',
                        showConfirmButton: true,
                        timer: 2500
                    })
                }
                else if (response.data.kegiatan || response.data.id_kelas || response.data.tanggal_mulai || response.data.tanggal_berakhir) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Form wajib diisi!',
                        showConfirmButton: true,
                        timer: 2500
                    })
                }
            })
    }


    </script>
@endpush