<?php

Route::get('/', function () {
    if (Auth::user()) {
        return redirect('admin/dashboard');
    }
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::resource('kelas', 'KelasController');
Route::resource('guru', 'GuruController');
Route::resource('santri', 'SantriController');
Route::resource('jadwal-absensi', 'JadwalAbsensiController');
Route::get('/admin/{pages}', 'AdminController@pages');