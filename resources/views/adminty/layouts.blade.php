<!DOCTYPE html>
<html lang="en">
<head>
    <title>Adminty - Premium Admin Template by Colorlib </title>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="#">
    <meta name="author" content="#">
    <link rel="icon" href="{{ asset('files\assets\images\favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\bower_components\bootstrap\css\bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\icon\feather\css\feather.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/icon/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\css\style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('files\assets\css\jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="index-1.htm">
                            <img class="img-fluid" src="{{ asset('files\assets\images\logo.png') }}" alt="Theme-Logo">
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{{ asset('files\assets\images\avatar-4.jpg') }}" class="img-radius" alt="User-Profile-Image">
                                        <span>{{Auth::user()->username}}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="#!">
                                                <i class="feather icon-settings"></i> Pengaturan
                                            </a>
                                        </li>
                                        <li>
                                            <a href="user-profile.htm">
                                                <i class="feather icon-user"></i> Profil
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="feather icon-log-out"></i> Logout
                                            </a>
                                            <form id="logout-form" class="d-none" action="{{route('logout')}}" method="post">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar" navbar-theme="themelight1">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Menu Utama</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="">
                                    <a href="{{url('admin/dashboard')}}">
                                        <span class="pcoded-micon">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                        </span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon">
                                            <i class="fa fa-database" aria-hidden="true"></i>
                                        </span>
                                        <span class="pcoded-mtext">Data Master</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="{{url('admin/data-kelas')}}">
                                                <span class="pcoded-mtext">Data Kelas</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="{{url('admin/data-guru')}}">
                                                <span class="pcoded-mtext">Data Guru</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="{{url('admin/data-santri')}}">
                                                <span class="pcoded-mtext">Data Santri</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </span>
                                        <span class="pcoded-mtext">Absensi</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" ">
                                            <a href="{{url('admin/absen-santri')}}">
                                                <span class="pcoded-mtext">Absen Santri</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="{{url('admin/jadwal-absensi')}}">
                                                <span class="pcoded-mtext">Jadwal Absensi</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="{{url('admin/pengaturan-absensi')}}">
                                                <span class="pcoded-mtext">Pengaturan Absensi</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                        @yield('content')
                                    </div>
                                </div>

                                <div id="styleSelector">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="{{ asset('cdn-cgi\scripts\5c5dd728\cloudflare-static\email-decode.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\jquery\js\jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\jquery-ui\js\jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\popper.js\js\popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\bootstrap\js\bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\modernizr\js\modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\bower_components\chart.js\js\Chart.js') }}"></script>
    <script src="{{ asset('files\assets\pages\widget\amchart\amcharts.js') }}"></script>
    <script src="{{ asset('files\assets\pages\widget\amchart\serial.js') }}"></script>
    <script src="{{ asset('files\assets\pages\widget\amchart\light.js') }}"></script>
    <script src="{{ asset('files\assets\js\jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\assets\js\SmoothScroll.js') }}"></script>
    <script src="{{ asset('files\assets\js\pcoded.min.js') }}"></script>
    <script src="{{ asset('files\assets\js\vartical-layout.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\assets\pages\dashboard\custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('files\assets\js\script.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    @stack('script')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();

             // update absensi
            axios({
                method: 'get',
                url: '{{url("api/jadwal-absensi")}}',
            })
            .then((response) => {
                    var d = new Date();
                    var weekday = new Array(7);
                    weekday[0] = "Sunday";
                    weekday[1] = "Monday";
                    weekday[2] = "Tuesday";
                    weekday[3] = "Wednesday";
                    weekday[4] = "Thursday";
                    weekday[5] = "Friday";
                    weekday[6] = "Saturday";

                    var n = weekday[d.getDay()];
                    
                    $.each(response.data,function(index,item){
                        if (item.nama_hari[0][n] === n) {
                            buatAbsensi(item.id_kelas)
                        }
                        else {
                            console.log('berhasil');
                        }
                    })
            }).catch((err) => {
                
            });


        } );

        function buatAbsensi(id_kelas){
            var id_kelas = id_kelas;
            axios({
                method: 'post',
                url: '{{url("api/detail-absensi")}}',
                data: {
                    id_kelas: id_kelas,
                }
            })
            .then((response) => {
            }).catch((err) => {
                
            });
        }
    </script>
</body>

</html>
