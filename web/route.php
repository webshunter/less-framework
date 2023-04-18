<?php

use NN\Route;
use NN\Session;
use NN\Link;
use NN\load;

$route = new Route();

$route->addMidleware('post', function(){
    new load('web/post');
    Post::cek();
});

$route->addMidleware('cekloginsiswa', function(){
    if(Session::get('loginsiswa') == ''){
        Session::put('message', 'silahkan login terlebih dahulu!');
        Link::redirect('/');
    }
});

$route->addMidleware('cekloginadmin', function(){
    if(Session::get('loginadmin') == ''){
        Session::put('message', 'silahkan login terlebih dahulu!');
        Link::redirect('/login/admin');
    }
});

$route->session(true);

$route->add(404, function(){
    new load('vendor/autoload', 'web/post');
    Post::err();
});

$route->add('/logout/siswa', 'module/http/app@logoutsiswa')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('cekloginsiswa');

$route->add('/logout/admin', 'module/http/app@logoutadmin')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('cekloginadmin');

$route->add('/api/{data}', 'module/http/app@api')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('post');

$route->add('/upload', 'module/http/app@upload')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('post');

$route->add('/login/proccess', 'module/http/app@login')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('post');

$route->add('/login/proccess/admin', 'module/http/app@loginadmin')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('post');

$route->add('/login/proccess/admin/qr', 'module/http/app@loginadminqr')
    ->use('vendor/autoload.php')
    ->use('module/db.php')
    ->middleware('post');

$route->add('/forgot/password',  'module/http/app@forgotpassword')
    ->use('module/db.php')
;

$route->add('/',  'module/http/app@home')
    ->use('vendor/autoload.php')
    ->use('module/db.php');

$route->add('/data', function(){
    print('data');
});

$route->add('/generator/qr', 'module/http/app@qr')
    ->use('module/phpqrcode/qrlib.php');

$route->add('/data/{param1}', 'module/http/app@index')
    ->use('vendor/autoload.php');

$route->add('/data/{param1}/ego', function(...$arg){
    var_dump($arg);
});

$route->add('/pages/{param1}', function(){
    print('data');
});

$route->add('/dashboard/siswa', 'module/http/app@siswa')
    ->middleware('cekloginsiswa')
    ->use('module/phpqrcode/qrlib.php')
    ->use('module/db.php')
    ->use('vendor/autoload.php');

$route->add('/dashboard/siswa/setting/{id}', 'module/http/app@setting')
    ->middleware('cekloginsiswa')
    ->use('module/db.php')
    ->use('module/phpqrcode/qrlib.php')
    ->use('vendor/autoload.php');


$route->add('/dashboard/siswa/datakehadiran', 'module/http/app@siswahadir')
    ->middleware('cekloginsiswa')
    ->use('module/db.php')
    ->use('vendor/autoload.php');


// cek Tesseract 
$route->add('/ocr/test', 'module/http/teseract@test')
    ->use('vendor/autoload.php');

require_once 'admin.php';


$route->call();
