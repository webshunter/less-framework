<?php

use NN\files;
use NN\dd;
use NN\Post;
use NN\Session;
use NN\Module\DB;
use NN\Link;
use NN\Enc;
use NN\module\View;

class App{

    public static function pagenotfound(){
        $view = new View('views');
        echo $view->render('landing/index', ['name' => 'Jonathan']);
    }

    public static function home(...$arg){
        View::render('admin/landing');
    }

    public static function adminlogin(...$arg){
        $view = new View('views');
        echo $view->render('landing/adminlogin', ['name' => 'Jonathan']);
    }

    public static function index(...$arg){
        $view = new View('views');
        echo $view->render('temp/index', ['name' => 'Jonathan']);
    }

    public static function qr(...$arg){
        QRcode::png('PHP QR Code :)', 'test.png', 'L', 8, 2);
        echo "<img src='/test.png'>";
    }

    public static function login(){
        $post = new Post();
        $username = $post->name('username')->get();
        $password = $post->name('password')->md5()->get();
        $result = DB::dbquery("SELECT idsiswa id, count(*) tot FROM username WHERE username = '$username' AND password = '$password' ");
        if($result[0]->tot > 0){
            $id = $result[0]->id;
            $siswa = DB::dbquery("SELECT * FROM siswa WHERE id = '$id' ");
            if(count($siswa) > 0){
                Session::put('loginsiswa', $siswa[0]);
                Link::redirect('/dashboard/siswa');
            }
        }else{
            Session::put('message', 'pastikan password dan username benar!');
            Link::redirect('/');
        }
    }

    public static function loginadmin(){
        $post = new Post();
        $username = $post->name('username')->get();
        $password = $post->name('password')->md5()->get();
        $result = DB::dbquery("SELECT * FROM useradmin WHERE username = '$username' AND password = '$password' ");
        if(count($result) > 0){
            Session::put('loginadmin', $result[0]);
            Link::redirect('/dashboard/admin');
        }else{
            Session::put('message', 'pastikan password dan username benar!');
            Link::redirect('/login/admin');
        }
    }

    public static function loginadminqr(){
        $post = new Post();
        $username = $post->name('username')->get();
        $password = $post->name('password')->md5()->get();
        $result = DB::dbquery("SELECT * FROM useradmin WHERE username = '$username' AND password = '$password' ");
        if(count($result) > 0){
            print(json_encode($result[0]));
        }
    }

    public static function forgotpassword(){
        $ty = ["foo"=>true];
        $username = DB::dbquery("SELECT * FROM username");
        dd::table($username);
    }

    // dashboard siswa
    public static function siswa(...$arg){
        $view = new View('views');
        echo $view->render('landing/siswaadmin', ['name' => 'Jonathan']);
    }

    // dashboard siswa
    public static function setting(...$arg){
        if(isset($arg[0])){
            $view = new View('views');
            $id = $arg[0];
            $data = [
                'data' => DB::dbquery("SELECT * FROM username WHERE idsiswa='$id' ")[0],
                'id' => $arg[0]
            ];
            echo $view->render('landing/setting', $data);
        }else{

        }
    }

    // dashboard admin
    public static function admin(...$arg){
        $view = new View('views');
        echo $view->render('landing/admin', ['name' => 'Jonathan']);
    }

    // dashboard admin
    public static function datasiswa(...$arg){
        $data = [];
        $page = 0;
        if(isset($arg[0])){
          $page = $arg[0];
        }
        $cari = "";
        $linkcari = "";
        if(isset($arg[1])){
          $c = $arg[1];
          $linkcari = $c;
          $cari = " (nama LIKE '%$c%' OR hp LIKE '%$c%' OR pembina LIKE '%$c%' ) ";
        }

        $cond = "";

        if($cari != ""){
          $cond = " WHERE ";
        }

        $data['cari'] = $linkcari;
        $data['page'] = $page;
        $siswa = DB::dbquery("SELECT * FROM siswa $cond $cari LIMIT $page , 20");
        $total = DB::dbquery("SELECT count(*) tot FROM siswa $cond $cari ")[0]->tot;
        $data['siswa'] = $siswa;
        $data['total'] = $total;
        $view = new View('views');
        echo $view->render('landing/datasiswa', $data);
    }

    // dashboard admin
    public static function jadwalacara(...$arg){
        $view = new View('views');
        echo $view->render('landing/jadwalacara', ['name' => 'Jonathan']);
    }

    // dashboard siswa
    public static function siswahadir(...$arg){
        $view = new View('views');
        echo $view->render('landing/siswahadir', ['name' => 'Jonathan']);
    }

    public static function dbqueryNum($qr = ""){
        $p = explode("FROM", $qr);
		unset($p[0]);
		$p = join(" FROM ", $p);
        $p = "SELECT COUNT(*) as num FROM ".$p;
        $p = DB::query_result_object($p);
        if(count($p) > 0){
            $p = $p[0]->num;
            return $p;
        }else{
            return 0;
        }
    }

    public static function api(...$arg){
        if(isset($arg[0])){

          $valid = json_decode(base64_decode($arg[0]),true);

          $tipe = $_POST['tipe'];
          $changefile = $_POST['enm']."changefile.chache";
          if ($_POST['start'] != $_POST['end']) {
            $ok = $_POST['ok'];
            $start = $_POST['start'];
            # code...
            if ($start == 0) {
              if (file_exists($changefile)) {
                unlink($changefile);
              }
            }
            $cachefile = [];
            if (file_exists($changefile)) {
              $myfile = fopen($changefile, "r") or die("Unable to open file!");
              $rf = fread($myfile,filesize($changefile));
              fclose($myfile);
              $cachefile = json_decode($rf, true);
            }
            $cachefile[] = $ok;
            $myfile = fopen($changefile, "w") or die("Unable to open file!");
            $txt = json_encode($cachefile, true);
            fwrite($myfile, $txt);
            fclose($myfile);
            echo $start;
          }else{
            $ok = $_POST['ok'];
            $start = $_POST['start'];
            # code...
            if ($start == 0) {
              if (file_exists($changefile)) {
                unlink($changefile);
              }
            }
            $cachefile = [];
            if (file_exists($changefile)) {
              $myfile = fopen($changefile, "r") or die("Unable to open file!");
              $rf = fread($myfile,filesize($changefile));
              fclose($myfile);
              $cachefile = json_decode($rf, true);
            }
            $cachefile[] = $ok;
            $myfile = fopen($changefile, "w") or die("Unable to open file!");
            $txt = json_encode($cachefile, true);
            fwrite($myfile, $txt);
            fclose($myfile);
            // query prosses here ----------------- //
            $cachefile = [];
            if (file_exists($changefile)) {
              $myfile = fopen($changefile, "r") or die("Unable to open file!");
              $rf = fread($myfile,filesize($changefile));
              fclose($myfile);
              $cachefile = json_decode($rf, true);
            }
            unlink($changefile);
            $base64 = "";
            foreach ($cachefile as $key => $b64) {
              $base64 .= $b64;
            }

            $ifp = fopen($tipe, 'wb');

            $ok = base64_decode($base64);

            $data = null;
            if(
                strpos($ok, "INSERT INTO ") === false &&
                strpos($ok, "insert into ") === false &&
                strpos($ok, "delete ") === false &&
                strpos($ok, "update ") === false &&
                strpos($ok, "UPDATE ") === false &&
                strpos($ok, "DELETE ") === false
            ){
              $search = 'auto_increment';
              if(preg_match("/{$search}/i", $ok)) {
                $data = DB::query_result_object($ok);
              }else{
                $data = DB::query_result_object($ok);
              }
            }else{
              $data = DB::query($ok);
            }

            if(
                strpos($ok, "INSERT INTO ") === false &&
                strpos($ok, "insert into ") === false &&
                strpos($ok, "delete ") === false &&
                strpos($ok, "update ") === false &&
                strpos($ok, "UPDATE ") === false &&
                strpos($ok, "DELETE ") === false
            ){
              $qrcount = $ok;
              if (strpos($ok, 'LIMIT') !== false) {
                $qrcount = explode("LIMIT", $ok)[0];
              }
              echo json_encode([
              "data" => $data,
              "count" => (new self)->dbqueryNum($qrcount)
              ]);
            }else{
              echo $data;
            }

          }
        }
    }

    public static function upload(...$arg){


          $user = $valid['username'];
          $pass = $valid['password'];

          $tipe = $_POST['tipe'];
          $changefile = $_POST['enm']."changefile.chache";
          if ($_POST['start'] != $_POST['end']) {
            $ok = $_POST['ok'];
            $start = $_POST['start'];
            # code...
            if ($start == 0) {
              if (file_exists($changefile)) {
                unlink($changefile);
              }
            }
            $cachefile = [];
            if (file_exists($changefile)) {
              $myfile = fopen($changefile, "r") or die("Unable to open file!");
              $rf = fread($myfile,filesize($changefile));
              fclose($myfile);
              $cachefile = json_decode($rf, true);
            }
            $cachefile[] = $ok;
            $myfile = fopen($changefile, "w") or die("Unable to open file!");
            $txt = json_encode($cachefile, true);
            fwrite($myfile, $txt);
            fclose($myfile);
            echo $start;
          }else{
            $ok = $_POST['ok'];
            $start = $_POST['start'];
            # code...
            if ($start == 0) {
              if (file_exists($changefile)) {
                unlink($changefile);
              }
            }

            $cachefile = [];
            if (file_exists($changefile)) {
              $myfile = fopen($changefile, "r") or die("Unable to open file!");
              $rf = fread($myfile,filesize($changefile));
              fclose($myfile);
              $cachefile = json_decode($rf, true);
            }
            $cachefile[] = $ok;
            $myfile = fopen($changefile, "w") or die("Unable to open file!");
            $txt = json_encode($cachefile, true);
            fwrite($myfile, $txt);
            fclose($myfile);
            // query prosses here ----------------- //
            $cachefile = [];
            if (file_exists($changefile)) {
              $myfile = fopen($changefile, "r") or die("Unable to open file!");
              $rf = fread($myfile,filesize($changefile));
              fclose($myfile);
              $cachefile = json_decode($rf, true);
            }
            unlink($changefile);
            $base64 = "";
            foreach ($cachefile as $key => $b64) {
              $base64 .= $b64;
            }

            $ifp = fopen($tipe, 'wb');

            function base64_to_jpeg($base64_string, $output_file) {
                // open the output file for writing
                $ifp = fopen( $output_file, 'wb' );

                // split the string on commas
                // $data[ 0 ] == "data:image/png;base64"
                // $data[ 1 ] == <actual base64 string>
                $data = explode( ',', $base64_string );

                // we could add validation here with ensuring count( $data ) > 1
                fwrite( $ifp, base64_decode( $data[ 1 ] ) );

                // clean up the file resource
                fclose( $ifp );

                return $output_file;
            }
            
            base64_to_jpeg($base64, strtolower($tipe));

          }
    }

    public static function jadwalacaratambah(){
        $view = new View('views');
        echo $view->render('landing/jadwalacaratambah', ['name' => 'Jonathan']);
    }

    public static function simpanjadwal(){

        $data = $_POST;
        DB::insert('jadwal', $data);
        Link::redirect('/dashboard/admin/jadwal/absensi/'.$data['id']);

    }

    public static function jadwal(...$arg){
        if(isset($arg[0])){
            $id = $arg[0];
            $data = [
                "idjadwal" => $arg[0],
                "status" => DB::dbquery("SELECT * FROM jadwal WHERE id = '$id' ")[0]->status
            ];
            $view = new View('views');
            echo $view->render('landing/absensiswa', $data);
        }

    }

    public static function apiserver(){
        header('Access-Control-Allow-Origin: *');
        $server = DB::dbquery("SELECT * FROM servername ");
        echo json_encode($server);
    }

    public static function apiacara(){
        header('Access-Control-Allow-Origin: *');
        $server = DB::dbquery("SELECT * FROM jadwal WHERE status = 0 ");
        echo json_encode($server);
    }

    public static function apiabsen(...$arg){
        header('Access-Control-Allow-Origin: *');
        $idjadwal = $arg[0];
        $idsiswa = $arg[1];

        if(DB::dbquery("SELECT count(*) tot FROM jadwal WHERE id = '$idjadwal' AND status = 0 ")[0]->tot == 0){
          echo "absensi ditutup";
          die();
        }

        $cek = DB::dbquery("SELECT * FROM absen WHERE idjadwal = '$idjadwal' AND idsiswa = '$idsiswa' ");
        if(count($cek) == 0){
            $siswa = DB::dbquery("SELECT * FROM siswa WHERE id = '$idsiswa' ")[0];
            $data = [
                "idjadwal" => $idjadwal,
                "idsiswa" => $idsiswa,
                "nama" => $siswa->nama,
                "tanggal" => date('Y-m-d'),
                "jam" => date('h:i:s'),
                "lokasi" => ''
            ];
            DB::insert("absen",$data);
            echo "absen : ".date('d-m-Y h:i:s');
        }else{
            echo "sudah absen";
        }

    }

    public static function logoutsiswa(){
        Session::delete('loginsiswa');
        Link::redirect('/');
    }

    public static function logoutadmin(){
        Session::delete('loginadmin');
        Link::redirect('/login/admin');
    }

    public static function siswaedit(...$arg){
      if(isset($arg[0])){
        $view = new View('views');
        echo $view->render('landing/editsiswa', ['id' => $arg[0]]);
      }
    }

    public static function editsiswa(...$arg){
      if(isset($arg[0])){
        $view = new View('views');
        echo $view->render('landing/editsiswaadmin', [
          'id' => Enc::decrypt($arg[0]) 
        ]);
      }
    }

    public static function datasiswabaru(){
      $new = DB::dbquery("SELECT AUTO_INCREMENT new
        FROM information_schema.tables
        WHERE table_name = 'siswa'
        and table_schema = 'admin_absensi'
      ")[0]->new;
     DB::query("INSERT INTO siswa (id) VALUES ('$new')");
     Link::redirect('/dashboard/admin/datasiswa/siswa/'.$new);
    }



}
