<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/'], function() use ($app){

    // Autentikasi user
    $app->post('login', 'AuthController@login');
    $app->post('profil', 'UserController@profil');
    $app->get('profil', 'UserController@profil');
    $app->post('ganti-password', 'UserController@gantiPassword');

    // mengambil data pengguna untuk ditampilkan pada tabel
    $app->get('pengguna', 'UserController@index');
    $app->get('mahasiswa', 'MahasiswaController@index');
    $app->get('dosen', 'DosenController@index');
    $app->get('teknisi', 'TeknisiController@index');

    // memanipulasi data pengguna
    $app->get('pengguna/edit', 'UserController@edit');
    $app->get('pengguna/find', 'UserController@search');
    
    $app->post('pengguna', 'UserController@tambah');
    $app->post('pengguna/edit', 'UserController@ubah');
    $app->post('pengguna/hapus', 'UserController@hapus');

    // menampilkan dan memanipulasi data barang
    $app->get('barang', 'BarangController@index');
    $app->get('barang/edit', 'BarangController@edit');
    $app->get('barang/find', 'BarangController@search');

    $app->post('barang', 'BarangController@tambah');
    $app->post('barang/edit', 'BarangController@ubah');
    $app->post('barang/hapus', 'BarangController@hapus');

    // menampilkan data jadwal dan memanipulasi data jadwal
    $app->get('jadwal', 'JadwalController@index');
    $app->get('jadwal/edit', 'JadwalController@edit');
    $app->get('jadwal/find', 'JadwalController@search');

    $app->post('jadwal', 'JadwalController@tambah');
    $app->post('jadwal/edit', 'JadwalController@ubah');
    $app->post('jadwal/hapus', 'JadwalController@hapus');

    // menampilkan dan memanipulasi data peminjaman
    $app->get('peminjaman', 'PeminjamanController@index');
    $app->get('peminjaman/edit', 'PeminjamanController@edit');
    $app->get('peminjaman/find', 'PeminjamanController@search');

    $app->post('peminjaman', 'PeminjamanController@tambah');
    $app->post('peminjaman/edit', 'PeminjamanController@ubah');
    $app->post('peminjaman/hapus', 'PeminjamanController@hapus');

    // menampilkan dan memanipulasi data perawatan
    $app->get('perawatan', 'PerawatanController@index');
    $app->get('perawatan/edit', 'PerawatanController@edit');
    $app->get('perawatan/find', 'PerawatanController@search');
    $app->post('perawatan', 'PerawatanController@store');
    $app->post('perawatan/edit', 'PerawatanController@update');
    $app->post('perawatan/hapus', 'PerawatanController@delete');
    
    // memanipulasi data mata kuliah
    $app->post('makul', 'MakulController@store');
    $app->put('makul', 'MakulController@update');
    $app->delete('makul', 'MakulController@delete');

    // memanipulasi data kelas
    $app->post('kelas', 'KelasController@store');
    $app->put('kelas', 'KelasController@update');
    $app->delete('kelas', 'KelasController@delete');

    // memanipulasi data program studi
    $app->post('prodi', 'ProdiController@store');
    $app->put('prodi', 'ProdiController@update');
    $app->delete('prodi', 'ProdiController@delete');

    // memanipulasi data ruang
    $app->post('ruang', 'RuangController@store');
    $app->put('ruang', 'RuangController@update');
    $app->delete('ruang', 'RuangController@delete');
});
