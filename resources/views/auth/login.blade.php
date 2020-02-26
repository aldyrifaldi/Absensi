<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Absensi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background:#F7F7F7">
    <div class="container-fluid py-5">
        <div class="row justify-content-center my-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        {{-- <small>
                            <a href="">
                                Kembali
                            </a>
                        </small><br> --}}
                        <div class="text-center my-3">
                            <img src="https://images.unsplash.com/photo-1511091734515-e50d46c37240?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="" class="img-fluid rounded-circle" style="width:200px;height:200px">
                        </div>
                        <form action="{{route('login')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Username</label>
                                <input required type="text"
                                class="form-control @error('username') is-invalid @enderror" name="username" id="" aria-describedby="helpId" placeholder="Username">
                                <small id="helpId" class="form-text text-muted">Masukkan Username Anda</small>
                                @error('username')
                                    <small class="text-danger"> {{$message}} </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input required type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" id="" aria-describedby="helpId" placeholder="Password">
                                <small id="helpId" class="form-text text-muted">Masukkan Password Anda</small>
                                @error('password')
                                    <small class="text-danger"> {{$message}} </small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-block btn-outline-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>