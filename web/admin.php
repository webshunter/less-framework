<?php

$route->add('/login/admin',  'module/http/app@adminlogin')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin', 'module/http/app@admin')
    ->middleware('cekloginadmin')
    ->use('module/phpqrcode/qrlib.php')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin/datasiswa', 'module/http/app@datasiswa')
    ->middleware('cekloginadmin')
    ->use('module/db.php')
    ->use('module/phpqrcode/qrlib.php')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin/datasiswa/baru', 'module/http/app@datasiswabaru')
    ->middleware('cekloginadmin')
    ->use('module/db.php')
    ->use('module/phpqrcode/qrlib.php')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin/datasiswa/{halaman}', 'module/http/app@datasiswa')
    ->middleware('cekloginadmin')
    ->use('module/db.php')
    ->use('module/phpqrcode/qrlib.php')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin/datasiswa/{halaman}/{cari}', 'module/http/app@datasiswa')
    ->middleware('cekloginadmin')
    ->use('module/db.php')
    ->use('module/phpqrcode/qrlib.php')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin/jadwal', 'module/http/app@jadwalacara')
    ->middleware('cekloginadmin')
    ->use('module/phpqrcode/qrlib.php')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin/jadwal/tambah', 'module/http/app@jadwalacaratambah')
    ->middleware('cekloginadmin')
    ->use('vendor/autoload.php');

$route->add('/dashboard/admin/jadwal/simpan', 'module/http/app@simpanjadwal')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('cekloginadmin')
    ->middleware('post');

$route->add('/dashboard/admin/jadwal/absensi/{id}', 'module/http/app@jadwal')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('cekloginadmin');

$route->add('/api/server', 'module/http/app@apiserver')
    ->use('vendor/autoload.php')
    ->use('module/db.php');

$route->add('/api/acara', 'module/http/app@apiacara')
    ->use('vendor/autoload.php')
    ->use('module/db.php');

$route->add('/api/absen/{idacara}/{idsiswa}', 'module/http/app@apiabsen')
    ->use('vendor/autoload.php')
    ->use('module/db.php');

$route->add('/dashboard/siswa/edit/{idsiswa}', 'module/http/app@siswaedit')
    ->use('vendor/autoload.php')
    ->middleware('cekloginsiswa')
    ->use('module/phpqrcode/qrlib.php')
    ->use('module/db.php');

$route->add('/dashboard/admin/datasiswa/siswa/{idsiswa}', 'module/http/app@editsiswa')
    ->use('vendor/autoload.php')
    ->middleware('cekloginadmin')
    ->use('module/phpqrcode/qrlib.php')
    ->use('module/db.php');
