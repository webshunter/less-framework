<?php
    use NN\Session;
    use NN\files;
    use NN\Module\DB;
    $id = Session::get('loginsiswa')->id;
    $login = Db::dbquery("SELECT * FROM siswa WHERE id = '$id' ")[0];
    $barcode = json_encode([
        "id" => $login->id,
        "nama" => $login->nama
    ]);
    $profile = 'fotoprofilesiswa/'.strtolower(str_replace(" ", "-",$login->nama)).'.jpg';
    if(files::exist($profile) === false){
        $profile = files::read('fotoprofilesiswa/profile.file');
    }else{
      $profile = PATH.'/'.$profile.'?v='.date('ymdhis');
    }
    $namefile = 'userqr/'.$login->id.'.png';
    QRcode::png($barcode, $namefile, 'L', 8, 2);
    
?>
<?php $this->layout('temp/layout', ['title' => $login->nama.' || Dashboard Siswa']) ?>

<?php $this->insert('landing/navbar/siswa') ?>

<?php $this->insert('siswa/styleprofile') ?>

<div class="container mt-3">
    <div class="row">
        <div class="col-12 col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <img class="w-100" src="<?= PATH ?>/<?= $namefile ?>" >
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 mb-3">
            <div class="card">
                <div class="card-body">
                    <?php $this->insert('siswa/headprofile', [
                        'data' => $login, 
                        'profile' => $profile 
                    ]) ?>

                    <?php $this->insert('siswa/bodyprofile', [
                        'data' => $login
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
